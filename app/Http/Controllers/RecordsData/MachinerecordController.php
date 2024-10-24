<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\Machine;
use App\YearlySchedule;
use App\MonthlySchedule;
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
                $refreshrecords = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.monthly_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->groupBy('monthly_schedules.id')
                ->selectRaw('count(machine_schedules.monthly_id) as machine_count')
                ->orderBy('monthly_schedules.id', 'asc')
                ->get();
            return response()->json([
                'refreshrecords' => $refreshrecords
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function refreshdetailtablerecord($id)
    {
        try {
            $refreshdetailrecord = DB::table('monthly_schedules')
            ->select('monthly_schedules.id', 'machines.*', 'machine_schedules.*', 'machine_schedules.id as schedule_id')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->where('monthly_schedules.id', '=', $id)
            ->get();
            return response()->json([
                'refreshdetailrecord' => $refreshdetailrecord,
                'schedule_id' => $refreshdetailrecord->pluck('schedule_id')
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    // fungsi menampilkan tabel dan merefresh tabel history preventice
    public function refreshtablehistory()
    {
        $refreshrecord = DB::table('machinerecords')
            ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.created_at as created_date', 'machinerecords.correct_by as getcorrect', 'machinerecords.approve_by as getapprove')
            ->join('machine_schedules', 'machinerecords.id_machine_schedule', '=', 'machine_schedules.id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->orderBy('machinerecords.id', 'desc')
            ->get();
        return response()->json([
            'joinrecords' => $refreshrecord
        ]);
    }

    // fungsi tampilan formulir untuk melihat riwayat dan status preventive mesin (record mesin)
    public function detailpreventive($id)
    {
        try{
            $machinedata = DB::table('machinerecords')
                ->select('machinerecords.id_machine_schedule', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machine_schedules', 'machinerecords.id_machine_schedule', '=', 'machine_schedules.id')
                ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usersdata = DB::table('machinerecords')
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usernames = [];
            $userarray = json_decode($usersdata->first()->create_by);
            $userids = explode(',', $userarray[0]);


            foreach ($userids as $eachuserid){
                $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
            }

            $IsAbnormalExist = $usersdata->first()->abnormal_record;
            $abnormals = [];
            if ($IsAbnormalExist != null) {
                $abnormal_array = json_decode($usersdata->first()->abnormal_record);
                $abnormalid = explode(',', $abnormal_array[0]);

                foreach ($abnormalid as $eachabnormal) {
                    $abnormals[] = DB::table('componenchecks')->select('name_componencheck')->where('id', $eachabnormal)->first()->name_componencheck;
                }
            }

            $combineresult[] = [
                'operator_action' => $usersdata->first()->operator_action,
                'result' => $usersdata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'usersdata' => $usersdata,
                'combineresult' => $combineresult,
                'usernames' => $usernames,
                'abnormals' => $abnormals,
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi tampilan formulir untuk mengisi preventive mesin (record mesin)
    public function formmachinerecord($id)
    {
        $users = User::get();
        $timenow = Carbon::now();

        $getcomponen = DB::table('machine_schedules')
        ->select('machine_schedules.*', 'machines.*', 'machineproperties.*', 'componenchecks.*')
        ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
        ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
        ->join('componenchecks', 'componenchecks.id_property2', '=', 'machineproperties.id')
        ->where('machine_schedules.id', '=', $id)
        ->get();

        $joinmachine = DB::table('machine_schedules')
        ->select('machine_schedules.*', 'machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
        ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
        ->join('componenchecks', 'componenchecks.id_property2', '=', 'machineproperties.id')
        ->join('parameters', 'parameters.id_componencheck', '=', 'componenchecks.id')
        ->join('metodechecks', 'metodechecks.id_parameter', '=', 'parameters.id')
        ->where('machine_schedules.id', '=', $id)
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
        $schedule_id = ($request->input('id_schedule'));
        $abnormal = ($request->input('combined_abnormal'));

        $abnormal_json = json_encode($abnormal);
        $create_by_json = json_encode($request->input('combined_create_by'));
        $operator_action_json = json_encode(array_values($request->input('operator_action')));
        $result_json = json_encode(array_values($request->input('result')));

        $currenttime = Carbon::now('Asia/Jakarta');
        $schedulenext = $currenttime->copy()->addMonths(6);

        $getshifttime = Carbon::now()->format('H:i');
        if ($getshifttime >= '07:00' && $getshifttime < '15:59') {
            $shifttime = 'Shift 1';
        } elseif ($getshifttime >= '16:00' && $getshifttime < '00:15') {
            $shifttime = 'Shift 2';
        } else {
            $shifttime = 'Diluar Shift Atau Lembur';
        }

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

        $StoreRecords = new Machinerecord();
        $StoreRecords->machine_number2 = $request->input('machine_number');
        $StoreRecords->shift = $shifttime;
        $StoreRecords->note = $request->input('note');
        $StoreRecords->id_machine_schedule = $schedule_id;
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

        $StoreSchedule = Machineschedule::find($schedule_id);
        $StoreSchedule->schedule_next = $schedulenext;
        $StoreSchedule->machine_schedule_status = true;
        $StoreSchedule->save();

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
            $refreshrecord = DB::table('machine_schedules')
                ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.created_at as created_date')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->orderBy('machine_schedules.id', 'asc')
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
            $machinedata = DB::table('machinerecords')
                ->select('machinerecords.id_machine_schedule', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machine_schedules', 'machinerecords.id_machine_schedule', '=', 'machine_schedules.id')
                ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usersdata = DB::table('machinerecords')
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usernames = [];
            $userarray = json_decode($usersdata->first()->create_by);
            $userids = explode(',', $userarray[0]);

            foreach ($userids as $eachuserid){
                $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
            }

            $IsAbnormalExist = $usersdata->first()->abnormal_record;
            $abnormals = [];
            if ($IsAbnormalExist != null) {
                $abnormal_array = json_decode($usersdata->first()->abnormal_record);
                $abnormalid = explode(',', $abnormal_array[0]);

                foreach ($abnormalid as $eachabnormal) {
                    $abnormals[] = DB::table('componenchecks')->select('name_componencheck')->where('id', $eachabnormal)->first()->name_componencheck;
                }
            }

            $combineresult[] = [
                'operator_action' => $usersdata->first()->operator_action,
                'result' => $usersdata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'usersdata' => $usersdata,
                'combineresult' => $combineresult,
                'usernames' => $usernames,
                'abnormals' => $abnormals,
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    // fungsi untuk mengkoreksi dan meregister hasil preventive mesin [leader + foreman + supervisor + ass.manager + manager only]
    public function registercorrection(Request $request, $id)
    {
        $request->validate([
            'correct_by' => 'required'
        ]);

        $currenttime = Carbon::now('Asia/Jakarta');
        $clear_abnormal = $request->input('clear_abnormals');

        if ($clear_abnormal == 1) {
            $record_status = true;
        } else {
            $record_status = false;
        }

        $StoreRecords = Machinerecord::find($id);

        if (!$StoreRecords) {
            return response()->json(['error' => 'Record not found !!!!'], 404);
        }
        else if ($StoreRecords->correct_by) {
            return response()->json(['error' => 'Pembaruan data gagal. Data sudah dikoreksi oleh orang lain.'], 422);
        }
        else {
            $StoreRecords->update([
                'machinerecord_status' => $record_status,
                'correct_by' => $request->input('correct_by'),
                'note' => $request->input('note'),
                'finish_preventive' => $currenttime,
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
            $refreshrecord = DB::table('machine_schedules')
                ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.created_at as created_date')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->orderBy('machine_schedules.id', 'asc')
                ->get();

        return response()->json([
                'refreshrecord' => $refreshrecord
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database untuk disetujui
    public function readdataapproval($id)
    {
        try{
            $machinedata = DB::table('machinerecords')
                ->select('machinerecords.id_machine_schedule', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machine_schedules', 'machinerecords.id_machine_schedule', '=', 'machine_schedules.id')
                ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usersdata = DB::table('machinerecords')
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usernames = [];
            $userarray = json_decode($usersdata->first()->create_by);
            $userids = explode(',', $userarray[0]);

            foreach ($userids as $eachuserid){
                $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
            }

            $IsAbnormalExist = $usersdata->first()->abnormal_record;
            $abnormals = [];
            if ($IsAbnormalExist != null) {
                $abnormal_array = json_decode($usersdata->first()->abnormal_record);
                $abnormalid = explode(',', $abnormal_array[0]);

                foreach ($abnormalid as $eachabnormal) {
                    $abnormals[] = DB::table('componenchecks')->select('name_componencheck')->where('id', $eachabnormal)->first()->name_componencheck;
                }
            }

            $combineresult[] = [
                'operator_action' => $usersdata->first()->operator_action,
                'result' => $usersdata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'usersdata' => $usersdata,
                'combineresult' => $combineresult,
                'usernames' => $usernames,
                'abnormals' => $abnormals,
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
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
