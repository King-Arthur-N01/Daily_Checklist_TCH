<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Machine;
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
        $machines = Machine::all();
        return view('dashboard.view_recordmesin.tablerecordmesin', ['machines' => $machines]);
    }
    // fungsi tampilan formulir $ajax untuk mengisi preventive mesin (record mesin)
    public function formmachinerecord($id)
    {
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
            'get_number'
        ]);
    }
    // fungsi meregister hasil formulir preventive mesin (record mesin) ke dalam database
    public function registermachinerecord(Request $request)
    {
        // dd($request);
        $getmachineid = ($request->input('id_machine'));
        // Check the table to see if data has been filled in before
        $lastsubmissiontime = Machinerecord::where('id_machine', $getmachineid)->value('record_time');

        if ($lastsubmissiontime){
            $lastsubmit = Carbon::parse($lastsubmissiontime);
            $currenttime = Carbon::now();
            if ($currenttime->diffInHours($lastsubmit) < 24 ){
                return redirect()->route('indexmachinerecord')->with('error', 'You can submit the form again after 24 hours.');
            }
            else{
                $StoreRecords = new Machinerecord();
                $StoreRecords->machine_number2 = $request->input('machine_number2');
                $StoreRecords->shift = $request->input('shift');
                $StoreRecords->note = $request->input('note');
                $StoreRecords->id_machine = $request->input('id_machine');
                $StoreRecords->record_time = $request->input('record_time');
                $StoreRecords->create_by = $request->input('create_by');
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
            $StoreRecords->shift = $request->input('shift');
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine = $request->input('id_machine');
            $StoreRecords->record_time = $request->input('record_time');
            $StoreRecords->create_by = $request->input('create_by');
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
    // <<<==============================batas approval machine records 1==============================>>>
    // <<<============================================================================================>>>

    // index tampilan untuk koreksi preventive mesin [leader + foreman + supervisor + ass.manager + manager only]
    public function indexcorrection()
    {
        $getrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'users.name as getuser')
            ->join('machines', 'machinerecords.id_machine', '=', 'machines.id')
            ->join('users', 'machinerecords.create_by', '=', 'users.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();

        return view('dashboard.view_recordmesin.tableapproval1', [
            'getrecords' => $getrecords
        ]);
    }
    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database
    public function fetchdatacorrection($id)
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
            ->select('machinerecords.*', 'historyrecords.*', 'users.*', 'machinerecords.id as get_id', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users', 'machinerecords.create_by', '=' ,'users.id')
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
        return response()->json([
            'machinedata' => $machinedata,
            'recordsdata' => $recordsdata,
            'combinedata' => $combinedata
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
            return response()->json(['error' => 'Data update failed. Record already corrected by someone else.'], 422);
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
    // <<<============================batas approval machine records 1 end============================>>>
    // <<<============================================================================================>>>


    // <<<============================================================================================>>>
    // <<<==============================batas approval machine records 2==============================>>>
    // <<<============================================================================================>>>

    // index tampilan untuk koreksi preventive mesin [supervisor + ass.manager + manager only]
    public function indexapproval()
    {
        $getrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'users.name as getuser')
            ->join('machines', 'machinerecords.id_machine', '=', 'machines.id')
            ->join('users', 'machinerecords.create_by', '=', 'users.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();

        return view('dashboard.view_recordmesin.tableapproval2', [
            'getrecords' => $getrecords
        ]);
    }
    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database
    public function fetchdataapproval($id) // this code for ajax modal html
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
            ->select('machinerecords.*', 'historyrecords.*', 'users.*', 'machinerecords.id as get_id', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users', 'machinerecords.create_by', '=' ,'users.id')
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
        return response()->json([
            'machinedata' => $machinedata,
            'recordsdata' => $recordsdata,
            'combinedata' => $combinedata
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
            return response()->json(['error' => 'Data update failed. Record has not been corrected by someone else.'], 422);
        }
        else if ($machinerecord->approve_by) {
            return response()->json(['error' => 'Data update failed. Record already been approved by someone else.'], 422);
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
    // <<<============================batas approval machine records 2 end============================>>>
    // <<<============================================================================================>>>
    public function destroy(Machinerecord $machinerecord)
    {
        //
    }
}
