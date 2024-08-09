<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\Machine;
use App\Schedule;
use App\Machinerecord;
use App\Historyrecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MachinerecordController extends Controller
{
    // fungsi untuk permission
    public function __construct(){
        $this->middleware('permission:#namapermission#', ['only' => ['#namafunction#']]);
    }
    // fungsi untuk melihat table preventive mesin
    public function indexmachinerecord()
    {
        return view('dashboard.view_recordmesin.tablerecordmesin');
    }
    // fungsi menampilkan tabel dan merefresh tabel
    public function refreshtablerecord() {
        $currenttime = Carbon::now();
        $machine = Machine::all();
        // $schedule = Schedule::all();
        $responsedata = [];
        try {
            foreach ($machine as $refreshmachine) {
                if ($refreshmachine->id_property){
                    $getschedule = Schedule::where('id_machine2', $refreshmachine->id)->value('schedule_time');
                    $lastrecord = Machinerecord::where('id_machine', $refreshmachine->id)->orderBy('record_time', 'desc')->first();
                    if ($lastrecord) {
                        $lasttime = Carbon::parse($lastrecord->record_time);
                        $totaltime = $currenttime->diff($lasttime);
                        $gettotalhours = $totaltime->format('%h:%I:%S');
                        $gettotaldays = $totaltime->format('%d');

                        $responsedata[] = [
                            'id' => $refreshmachine->id,
                            'machine_number' => $refreshmachine->machine_number,
                            'machine_name' => $refreshmachine->machine_name,
                            'machine_type' => $refreshmachine->machine_type,
                            'machine_brand' => $refreshmachine->machine_brand,
                            'getschedule' => $getschedule,
                            'total_hours' => $gettotalhours,
                            'total_days' => $gettotaldays,
                        ];
                    } else {
                        $responsedata[] = [
                            'id' => $refreshmachine->id,
                            'machine_number' => $refreshmachine->machine_number,
                            'machine_name' => $refreshmachine->machine_name,
                            'machine_type' => $refreshmachine->machine_type,
                            'machine_brand' => $refreshmachine->machine_brand,
                            'getschedule' => $getschedule,
                        ];
                    }
                }
            }
            return response()->json(
                $responsedata
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // public function gettablerecord($id) {
    //     $currenttime = Carbon::now();
    //     try {
    //         // Fetch the latest record for the given machine ID
    //         $lastrecord = Machinerecord::where('id_machine', $id)->orderBy('record_time', 'desc')->first();
    //         if ($lastrecord) {
    //             $lasttime = Carbon::parse($lastrecord->record_time);
    //             $totaltime = $currenttime->diff($lasttime);
    //             $gettotalhours = $totaltime->format('%h:%I:%S');
    //             $gettotaldays = $totaltime->format('%d');
    //             return response()->json([
    //                 'gettotalhours' => $gettotalhours,
    //                 'gettotaldays' => $gettotaldays
    //             ]);
    //         } else {
    //             return response()->json(['error' => 'No records found for the given machine ID'], 422);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error fetching data'], 500);
    //     }
    // }

    // fungsi tampilan formulir $ajax untuk mengisi preventive mesin (record mesin)
    public function formmachinerecord($id)
    {
        $users = User::get();
        $timenow = Carbon::now();

        $joinmachine = DB::table('machines')
        ->select('machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*', 'metodechecks.id as metodecheck_id')
        ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
        ->join('componenchecks', 'componenchecks.id_property2', '=', 'machineproperties.id')
        ->join('parameters', 'parameters.id_componencheck', '=', 'componenchecks.id')
        ->join('metodechecks', 'metodechecks.id_parameter', '=', 'parameters.id')
        ->where('machines.id', '=', $id)
        ->get();
        if ($joinmachine->isEmpty()) {
            // Return an error message or a default view
            return view('dashboard.view_blockpage.404', ['message' => 'No machine record found.']);
        }
        return view('dashboard.view_recordmesin.formrecordmesin', [
            'joinmachine' => $joinmachine,
            'machine_id' => $id,
            'timenow' => $timenow,
            'users' => $users,
            'get_number'
        ]);
    }
    // fungsi meregister hasil formulir preventive mesin (record mesin) ke dalam database
    public function createmachinerecord(Request $request)
    {
        $getmachineid = ($request->input('id_machine'));
        // Check the table to see if data has been filled in before
        $lastsubmissiontime = Machinerecord::where('id_machine', $getmachineid)->value('record_time');
        $currenttime = Carbon::now();

        $getshifttime = Carbon::now()->format('H:i');
        if ($getshifttime >= '07:00' && $getshifttime < '15:59') {
            $shifttime = 'Shift 1';
        } elseif ($getshifttime >= '16:00' && $getshifttime < '00:15') {
            $shifttime = 'Shift 2';
        } else {
            $shifttime = 'Diluar Shift Atau Lembur';
        }

        if ($lastsubmissiontime){
            $lastsubmit = Carbon::parse($lastsubmissiontime);

            if ($currenttime->diffInHours($lastsubmit) < 24 ){
                return redirect()->route('indexmachinerecord')->with('error', 'You can submit the form again after 24 hours.');
            }
            else{
                $StoreRecords = new Machinerecord();
                $StoreRecords->machine_number2 = $request->input('machine_number2');
                $StoreRecords->shift = $shifttime;
                $StoreRecords->note = $request->input('note');
                $StoreRecords->id_machine = $request->input('id_machine');
                $StoreRecords->record_time = $currenttime;
                $StoreRecords->create_by = $request->input('combined_create_by');
                $StoreRecords->save();

                // Get the ID of the newly created record
                $getrecordid = Machinerecord::latest('id')->first()->id;

                $metodecheck_id = $request->input('metodecheck_id', []);
                foreach ($metodecheck_id as $key => $test) {
                    $StoreHistory = new Historyrecords();
                    $StoreHistory->id_metodecheck = $test;
                    $StoreHistory->operator_action = implode(',', $request->input('operator_action')[$key]);
                    $StoreHistory->result = $request->input('result')[$key];
                    $StoreHistory->id_machinerecord = $getrecordid;
                    $StoreHistory->save();
                }
            }
        }else if(!$lastsubmissiontime){
            $StoreRecords = new Machinerecord();
            $StoreRecords->machine_number2 = $request->input('machine_number2');
            $StoreRecords->shift = $shifttime;
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine = $request->input('id_machine');
            $StoreRecords->record_time = $currenttime;
            $StoreRecords->create_by = $request->input('combined_create_by');
            $StoreRecords->save();

            // Get the ID of the newly created record
            $getrecordid = Machinerecord::latest('id')->first()->id;

            $metodecheck_id = $request->input('metodecheck_id', []);
            foreach ($metodecheck_id as $key => $test) {
                $StoreHistory = new Historyrecords();
                $StoreHistory->id_metodecheck = $test;
                $StoreHistory->operator_action = implode(',', $request->input('operator_action')[$key]);
                $StoreHistory->result = $request->input('result')[$key];
                $StoreHistory->id_machinerecord = $getrecordid;
                $StoreHistory->save();
            }
        }
        return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
    }




    // <<<============================================================================================>>>
    // <<<===============================batas koreksi machine records================================>>>
    // <<<============================================================================================>>>

    // index tampilan untuk koreksi preventive mesin [leader + foreman + supervisor + ass.manager + manager only]
    public function indexcorrection()
    {
        return view('dashboard.view_recordmesin.tableapproval1');
    }

    public function refreshtablecorrection()
    {
        try {
            $refreshrecord = DB::table('machinerecords')
                ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'users.name as getuser')
                ->join('machines', 'machinerecords.id_machine', '=', 'machines.id')
                ->join('users', 'machinerecords.create_by', '=', 'users.id')
                ->orderBy('machinerecords.id', 'asc')
                ->get();
            return response()->json([
                'refreshrecord' => $refreshrecord
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database untuk disetujui
    public function readdatacorrection($id)
    {
        $machinedata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machineproperties.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'metodechecks.id as checks_id')
            ->leftJoin('machines', 'machinerecords.id_machine', '=', 'machines.id')
            ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $recordsdata = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'machinerecords.id as get_id', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
            ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $combinedata = [];
        foreach ($machinedata as $getmachine){
            foreach ($recordsdata as $getrecords){
                if ($getmachine->checks_id == $getrecords->get_checks){
                    $combinedata[] = [
                        'machine_name' => $getmachine->machine_name,
                        'name_componencheck' => $getmachine->name_componencheck,
                        'name_parameter' => $getmachine->name_parameter,
                        'name_metodecheck' => $getmachine->name_metodecheck,
                        'operator_action' => $getrecords->operator_action,
                        'result' => $getrecords->result,
                    ];
                }
            }
        }
        $usernames = [];
        $combineuser = $recordsdata->first()->create_by;
        $splituser = explode(',', $combineuser);
        foreach ($splituser as $eachuserid){
            $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
        }

        return response()->json([
            'machinedata' => $machinedata,
            'recordsdata' => $recordsdata,
            'combinedata' => $combinedata,
            'usernames' => $usernames
        ]);
    }
    // fungsi untuk mensetujui dan meregister hasil preventive mesin [leader + foreman + supervisor + ass.manager + manager only]
    public function registercorrection(Request $request, $id)
    {
        $request->validate([
            'correct_by' => 'required'
        ]);
        $machinerecord = Machinerecord::find($id);
        if (!$machinerecord) {
            return response()->json(['error' => 'Record not found !!!!'], 404);
        }
        else if ($machinerecord->correct_by) {
            return response()->json(['error' => 'Pembaruan data gagal. Data sudah dikoreksi oleh orang lain.'], 422);
        }
        else {
            $machinerecord->update([
                'correct_by' => $request->input('correct_by'),
                'note' => $request->input('note')
            ]);
        }
        return response()->json(['success' => 'Data Preventive was successfully ACCEPTED']);
    }
    // public function rejectcorrection(Request $request, $id) // this code for ajax send request
    // {
    //     $request->validate([
    //         'reject_by' => 'required'
    //     ]);
    //     $machinerecord = Machinerecord::find($id);

    //     if (!$machinerecord->correct_by) {
    //         if (!$machinerecord) {
    //             return response()->json(['error' => 'Machine record not found'], 404);
    //         }
    //         else if ($machinerecord->reject_by) {
    //             return response()->json(['error' => 'Data update failed. Record already rejected by someone else.'], 422);
    //         }
    //         else {
    //             $machinerecord->update(['reject_by' => $request->input('reject_by')]);
    //         }
    //     } else if ($machinerecord->correct_by) {
    //         return response()->json(['error' => 'Data update failed. Record has been corrected by someone else.'], 422);
    //     }
    //     return response()->json(['success' => 'Data Preventive was successfully REJECT!']);
    // }

    // fungsi untuk menghapus preventive mesin (HATI-HATI FUNGSI INI DIBUAT UNTUK BERJAGA-JAGA JIKA ADA MASALAH PADA APLIKASI) [admin only]
    public function deletecorrection($id) {
        $deleterecords = Machinerecord::where('id', $id)->delete();

        if ($deleterecords > 0) {
            return response()->json(['success' => 'Record deleted successfully!']);
        } else {
            return response()->json(['error' => 'Failed to delete record.'], 422);
        }
    }
    // <<<============================================================================================>>>
    // <<<=============================batas koreksi machine records end==============================>>>
    // <<<============================================================================================>>>







    // <<<============================================================================================>>>
    // <<<===============================batas approval machine records===============================>>>
    // <<<============================================================================================>>>

    // index tampilan untuk koreksi preventive mesin [supervisor + ass.manager + manager only]
    public function indexapproval()
    {
        return view('dashboard.view_recordmesin.tableapproval2');
    }

    public function refreshtableapproval()
    {
        try {
            $refreshrecord = DB::table('machinerecords')
                ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'users.name as getuser')
                ->join('machines', 'machinerecords.id_machine', '=', 'machines.id')
                ->join('users', 'machinerecords.create_by', '=', 'users.id')
                ->orderBy('machinerecords.id', 'asc')
                ->get();
            return response()->json([
                'refreshrecord' => $refreshrecord
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database untuk disetujui
    public function readdataapproval($id) // this code for ajax modal html
    {
        $machinedata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machineproperties.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'metodechecks.id as checks_id')
            ->leftJoin('machines', 'machinerecords.id_machine', '=', 'machines.id')
            ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $recordsdata = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'machinerecords.id as get_id', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
            ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $combinedata = [];
        foreach ($machinedata as $getmachine){
            foreach ($recordsdata as $getrecords){
                if ($getmachine->checks_id == $getrecords->get_checks){
                    $combinedata[] = [
                        'machine_name' => $getmachine->machine_name,
                        'name_componencheck' => $getmachine->name_componencheck,
                        'name_parameter' => $getmachine->name_parameter,
                        'name_metodecheck' => $getmachine->name_metodecheck,
                        'operator_action' => $getrecords->operator_action,
                        'result' => $getrecords->result,
                    ];
                }
            }
        }
        $usernames = [];
        $combineuser = $recordsdata->first()->create_by;
        $splituser = explode(',', $combineuser);
        foreach ($splituser as $eachuserid){
            $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
        }

        return response()->json([
            'machinedata' => $machinedata,
            'recordsdata' => $recordsdata,
            'combinedata' => $combinedata,
            'usernames' => $usernames
        ]);
    }
    // fungsi untuk mensetujui dan meregister hasil preventive mesin [supervisor + ass.manager + manager only]
    public function registerapproval(Request $request, $id)
    {
        $request->validate([
            'approve_by' => 'required'
        ]);
        $machinerecord = Machinerecord::find($id);
        if (!$machinerecord) {
            return response()->json(['error' => 'Data record not found !!!!'], 404);
        }
        else if (!$machinerecord->correct_by) {
            return response()->json(['error' => 'Pembaruan data gagal. Data belum dikoreksi oleh orang lain.'], 422);
        }
        else if ($machinerecord->approve_by) {
            return response()->json(['error' => 'Pembaruan data gagal. Data sudah disetujui oleh orang lain.'], 422);
        }
        else {
            $machinerecord->update([
                'approve_by' => $request->input('approve_by'),
                'note' => $request->input('note')
            ]);
        }
        return response()->json(['success' => 'Data Preventive was successfully ACCEPTED']);
    }
    // public function rejectapproval(Request $request, $id) // this code for ajax send request
    // {
    //     $request->validate([
    //         'reject_by' => 'required'
    //     ]);
    //     $machinerecord = Machinerecord::find($id);
    //     if (!$machinerecord->approve_by) {
    //         if (!$machinerecord) {
    //             return response()->json(['error' => 'Data record not found !!!!'], 404);
    //         }
    //         else if (!$machinerecord->correct_by) {
    //             return response()->json(['error' => 'Data update failed. Record has not been corrected previously by someone else.'], 422);
    //         }
    //         else if ($machinerecord->reject_by) {
    //             return response()->json(['error' => 'Data update failed. Record already rejected by someone else.'], 422);
    //         }
    //         else {
    //             $machinerecord->update(['reject_by' => $request->input('reject_by')]);
    //         }
    //     } else if ($machinerecord->approve_by) {
    //         return response()->json(['error' => 'Data update failed. Record already been approved previously.'], 422);
    //     }
    //     return response()->json(['success' => 'Data Preventive was successfully REJECT!']);
    // }

    // fungsi untuk menghapus preventive mesin (HATI-HATI FUNGSI INI DIBUAT UNTUK BERJAGA-JAGA JIKA ADA MASALAH PADA APLIKASI) [admin only]
    public function deleteapproval($id) {
        $deleterecords = Machinerecord::where('id', $id)->delete();

        if ($deleterecords > 0) {
            return response()->json(['success' => 'Record deleted successfully!']);
        } else {
            return response()->json(['error' => 'Failed to delete record.'], 422);
        }
    }
    // <<<============================================================================================>>>
    // <<<===============================batas approval machine records===============================>>>
    // <<<============================================================================================>>>
    public function destroy(Machinerecord $machinerecord)
    {
        //
    }
}
