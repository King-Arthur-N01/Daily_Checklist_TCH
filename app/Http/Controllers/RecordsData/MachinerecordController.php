<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\Machine;
use App\Schedule;
use App\Machinerecord;
use App\Machineschedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    // fungsi untuk melihat history preventive mesin
    public function indexhistoryrecord()
    {
        return view('dashboard.view_history.tablehistory');
    }

    // fungsi menampilkan tabel dan merefresh tabel preventice
    public function refreshtablerecord() {
        try {
            $refreshschedule = Schedule::latest()->get();
            return response()->json([
                'refreshschedule' => $refreshschedule
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function refreshdetailtablerecord($id)
    {
        try {
            $schedule = Schedule::find($id);
            $machinearray = json_decode($schedule->id_machine, true);
            $getmachineid = [];
            $getmachinescheduleid = [];

            foreach ($machinearray as $eachmachineid) {
                $machine = Machine::where('id', $eachmachineid)->first();
                $getmachineid[] = $machine;
                $machineschedule = Machineschedule::where('id_machine2', $machine->id)->get();
                $getmachinescheduleid[] = $machineschedule;
            }
            return response()->json([
                'getmachineid' => $getmachineid,
                'getmachinescheduleid' => $getmachinescheduleid
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    // fungsi menampilkan tabel dan merefresh tabel history preventice
    public function refreshtablehistory()
    {
        $joinrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.created_at as getcreatedate', 'machinerecords.correct_by as getcorrect', 'machinerecords.approve_by as getapprove')
            ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();
        return response()->json([
            'joinrecords' => $joinrecords
        ]);
    }

    // fungsi tampilan formulir untuk melihat riwayat dan status preventive mesin (record mesin)
    public function detailpreventive($id)
    {
        try{
            $machinedata = DB::table('machines')
                ->select('machines.*', 'machineproperties.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machines.id', '=', $id)
                ->get();

            $recordsdata = DB::table('machines')
                ->select('machinerecords.*', 'machineschedules.*', 'machines.id_property', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name')
                ->leftJoin('machineschedules', 'machines.id', '=' ,'machineschedules.id_machine3')
                ->leftJoin('machinerecords', 'machines.id', '=' ,'machinerecords.id_machine2')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machines.id', '=', $id)
                ->get();

            $usernames = [];
            $userarray = json_decode($recordsdata->first()->create_by);
            $userids = explode(',', $userarray[0]);

            foreach ($userids as $eachuserid){
                $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
            }

            $IsAbnormalExist = $recordsdata->first()->abnormal_record;
            $abnormals = [];
            if ($IsAbnormalExist != null) {
                $abnormalarray = json_decode($recordsdata->first()->abnormal_record);
                $abnormalid = explode(',', $abnormalarray[0]);

                foreach ($abnormalid as $eachabnormal) {
                    $abnormals[] = DB::table('componenchecks')->select('name_componencheck')->where('id', $eachabnormal)->first()->name_componencheck;
                }
            }

            $combineresult = [];
            $combineresult[] = [
                'operator_action' => $recordsdata->first()->operator_action,
                'result' => $recordsdata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'recordsdata' => $recordsdata,
                'combineresult' => $combineresult,
                'usernames' => $usernames,
                'abnormals' => $abnormals,
            ]);
        } catch (\Exception $e) {
            Log::error('Error get machine data: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi tampilan formulir untuk mengisi preventive mesin (record mesin)
    public function formmachinerecord($id)
    {
        $users = User::get();
        $timenow = Carbon::now();

        $getcomponen = DB::table('machines')
        ->select('machines.*', 'machineproperties.*', 'componenchecks.*')
        ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
        ->join('componenchecks', 'componenchecks.id_property2', '=', 'machineproperties.id')
        ->where('machines.id', '=', $id)
        ->get();

        $joinmachine = DB::table('machines')
        ->select('machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
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
            'getcomponen' => $getcomponen,
            'machine_id' => $id,
            'timenow' => $timenow,
            'users' => $users,
        ]);
    }
    // fungsi meregister hasil formulir preventive mesin (record mesin) ke dalam database
    public function createmachinerecord(Request $request)
    {
        $machineid = ($request->input('id_machine'));
        $abnormal = ($request->input('combined_abnormal'));

        $abnormal_json = json_encode($abnormal);
        $create_by_json = json_encode($request->input('combined_create_by'));
        $operator_action_json = json_encode(array_values($request->input('operator_action')));
        $result_json = json_encode(array_values($request->input('result')));

        // Check the table to see if data has been filled in before
        $lastsubmissiontime = Machinerecord::where('id_machine2', $machineid)->value('created_at');
        $currenttime = Carbon::now();

        // $machineschedule = DB::table('machines')
        // ->select('machines.id', 'machineschedules.*')
        // ->join('machineschedules', 'machines.id', '=', 'machineschedules.id_machine3')
        // ->where('machines.id', '=', $machineid)
        // ->get();

        $getshifttime = Carbon::now()->format('H:i');
        if ($getshifttime >= '07:00' && $getshifttime < '15:59') {
            $shifttime = 'Shift 1';
        } elseif ($getshifttime >= '16:00' && $getshifttime < '00:15') {
            $shifttime = 'Shift 2';
        } else {
            $shifttime = 'Diluar Shift Atau Lembur';
        }

        // Function to check if array has non-null, non-empty values
        function hasValidAbnormalData($abnormal)
        {
            if (is_array($abnormal)) {
                foreach ($abnormal as $value) {
                    if (!is_null($value) && $value !== '') {
                        return true;
                    }
                }
            }
            return false;
        }

        if ($lastsubmissiontime){
            $lastsubmit = Carbon::parse($lastsubmissiontime);

            if ($currenttime->diffInHours($lastsubmit) < 24 ){
                return redirect()->route('indexmachinerecord')->with('error', 'You can submit the form again after 24 hours.');
            }else{
                $StoreRecords = new Machinerecord();
                $StoreRecords->machine_number2 = $request->input('machine_number');
                $StoreRecords->shift = $shifttime;
                $StoreRecords->note = $request->input('note');
                $StoreRecords->id_machine2 = $machineid;
                $StoreRecords->operator_action = $operator_action_json;
                $StoreRecords->result = $result_json;
                $StoreRecords->create_by = $create_by_json;
                $StoreRecords->start_preventive = $currenttime;
                if (hasValidAbnormalData($abnormal)) {
                    $StoreRecords->abnormal_record = $abnormal_json;
                    $StoreRecords->machinerecord_status = false;
                    $StoreRecords->finish_preventive = null;
                } else {
                    $StoreRecords->abnormal_record = null;
                    $StoreRecords->machinerecord_status = true;
                    $StoreRecords->finish_preventive = $currenttime;
                }
                $StoreRecords->save();

                $StoreSchedule = Machineschedule::where('id_machine3',$machineid);
                $StoreSchedule->schedule_record = $currenttime;
                $StoreSchedule->save();
            }
        }else if(!$lastsubmissiontime){
            $StoreRecords = new Machinerecord();
            $StoreRecords->machine_number2 = $request->input('machine_number');
            $StoreRecords->shift = $shifttime;
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine2 = $machineid;
            $StoreRecords->operator_action = $operator_action_json;
            $StoreRecords->result = $result_json;
            $StoreRecords->create_by = $create_by_json;
            $StoreRecords->start_preventive = $currenttime;
            if (hasValidAbnormalData($abnormal)) {
                $StoreRecords->abnormal_record = $abnormal_json;
                $StoreRecords->machinerecord_status = false;
                $StoreRecords->finish_preventive = null;
            } else {
                $StoreRecords->abnormal_record = null;
                $StoreRecords->machinerecord_status = true;
                $StoreRecords->finish_preventive = $currenttime;
            }
            $StoreRecords->save();

            $StoreSchedule = Machineschedule::where('id_machine3',$machineid);
            $StoreSchedule->schedule_record = $currenttime;
            $StoreSchedule->save();
        }

        // $StoreSchedule = Schedule::where('id',$scheduleid)->first();
        // $machinearray =  json_decode($StoreSchedule->id_machine);
        // $machinecount = count($machinearray);

        // $recordscount = DB::table('schedules')
        //     ->select('schedules.*', 'machinerecords.*')
        //     ->join('machinerecords', 'schedules.id', '=', 'machinerecords.id_schedule')
        //     ->where('schedules.id', '=', $scheduleid)
        //     ->groupBy('machinerecords.id_schedule')
        //     ->count();

        // if ($machinecount == $recordscount) {
        //     $StoreSchedule->schedule_status = true;
        //     $StoreSchedule->save();
        // }

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
            $refreshrecord = DB::table('machineschedules')
                ->select('machinerecords.*', 'machineschedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.created_at as created_date')
                ->join('machines', 'machineschedules.id_machine2', '=', 'machines.id')
                ->join('machineschedules', 'machinerecords.id_machineschedule', '=', 'machineschedules.id')
                ->orderBy('machineschedules.id', 'asc')
                ->get();

        return response()->json([
                'refreshrecord' => $refreshrecord
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database untuk dikoreksi
    public function readdatacorrection($id)
    {
        try{
            $machinedata = DB::table('machines')
                ->select('machinerecords.id_machine2', 'machines.*', 'machineproperties.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machinerecords', 'machines.id', '=', 'machinerecords.id_machine2')
                ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $recordsdata = DB::table('machinerecords')
                ->select('machinerecords.*', 'machines.id_property', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name')
                ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usernames = [];
            $userarray = json_decode($recordsdata->first()->create_by);
            $userids = explode(',', $userarray[0]);

            foreach ($userids as $eachuserid){
                $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
            }

            $IsAbnormalExist = $recordsdata->first()->abnormal_record;
            $abnormals = [];
            if ($IsAbnormalExist != null) {
                $abnormalarray = json_decode($recordsdata->first()->abnormal_record);
                $abnormalid = explode(',', $abnormalarray[0]);

                foreach ($abnormalid as $eachabnormal) {
                    $abnormals[] = DB::table('componenchecks')->select('name_componencheck')->where('id', $eachabnormal)->first()->name_componencheck;
                }
            }

            $combineresult[] = [
                'operator_action' => $recordsdata->first()->operator_action,
                'result' => $recordsdata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'recordsdata' => $recordsdata,
                'combineresult' => $combineresult,
                'usernames' => $usernames,
                'abnormals' => $abnormals,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    // fungsi untuk mengkoreksi dan meregister hasil preventive mesin [leader + foreman + supervisor + ass.manager + manager only]
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
                ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
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
            ->leftJoin('machines', 'machinerecords.id_machine2', '=', 'machines.id')
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

        $usernames = [];
        $combineuser = $recordsdata->first()->create_by;
        $splituser = explode(',', $combineuser);
        foreach ($splituser as $eachuserid){
            $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
        }

        $combinedata = [];
        foreach ($machinedata as $detail){
            $combinedata[] = [
                'machine_name' => $detail->machine_name,
                'name_componencheck' => $detail->name_componencheck,
                'name_parameter' => $detail->name_parameter,
                'name_metodecheck' => $detail->name_metodecheck,
            ];
        }
        $combineresult[] = [
            'operator_action' => $recordsdata->first()->operator_action,
            'result' => $recordsdata->first()->result
        ];

        return response()->json([
            'machinedata' => $machinedata,
            'recordsdata' => $recordsdata,
            'combinedata' => $combinedata,
            'combineresult' => $combineresult,
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
