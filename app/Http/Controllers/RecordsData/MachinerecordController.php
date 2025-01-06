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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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

    // fungsi menampilkan tabel dan merefresh tabel preventive
    public function refreshtablerecord()
    {
        try {
            $refreshrecords = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'monthly_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->orderBy('monthly_schedules.id', 'desc')
                ->get();

            return response()->json([
                'refreshrecords' => $refreshrecords,
            ]);
        } catch (\Exception $e) {
            Log::error('fetch data error: ' . $e->getMessage(), ['exception' => $e]);
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
            ->where('monthly_schedules.schedule_agreed', '=', !null)
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
        $joinrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.record_date as preventive_date', 'machinerecords.correct_by as getcorrect', 'machinerecords.approve_by as getapprove')
            ->join('machine_schedules', 'machinerecords.id_machine_schedule', '=', 'machine_schedules.id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->orderBy('machinerecords.id', 'desc')
            ->get();
        return response()->json([
            'joinrecords' => $joinrecords
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
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'machinerecords.id as record_id')
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

    public function printdatarecord($id)
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
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'machinerecords.id as record_id')
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

            // Render PDF
            $pdf = PDF::loadView('dashboard.view_history.printrecord', compact(['machinedata', 'usersdata', 'combineresult', 'usernames', 'abnormals']));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();
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
        try {
            // dd($request)->all();
            $schedule_id = ($request->input('id_schedule'));
            $abnormal = ($request->input('combined_abnormal'));

            $abnormal_json = json_encode($abnormal);
            $create_by_json = json_encode($request->input('combined_create_by'));
            $operator_action_json = json_encode(array_values($request->input('operator_action')));
            $result_json = json_encode(array_values($request->input('result')));

            $record_date = Carbon::parse($request->input('record_date'));
            $currenttime = Carbon::now('Asia/Jakarta');

            // NON AKTIFKAN PROTEKSI PERMINTAAN DARI MTN
            // $checkmachineschedule = Machineschedule::find($schedule_id);
            // $isExists = $checkmachineschedule->machine_schedule_status;

            // if ($isExists == 1) {
            //     return redirect()->route("indexmachinerecord")->withErrors('Error!!!! Checklist failed to add.');
            // }

            $getshifttime = Carbon::now()->format('H:i');
            if ($getshifttime >= '07:00' && $getshifttime < '15:59') {
                $shifttime = 'Shift 1';
            } elseif ($getshifttime >= '16:00' && $getshifttime < '23:59') {
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
            $StoreRecords->shift = $shifttime;
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine_schedule = $schedule_id;
            $StoreRecords->operator_action = $operator_action_json;
            $StoreRecords->result = $result_json;
            $StoreRecords->create_by = $create_by_json;
            $StoreRecords->record_date = $record_date;
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
            $schedule_start = Carbon::parse($StoreSchedule->schedule_start);
            $schedule_end = Carbon::parse($StoreSchedule->schedule_end);
            $schedule_date = Carbon::parse($StoreSchedule->schedule_date);
            $schedulenext = $schedule_date->copy()->addMonths(6);

            $reschedule_pm = null;

            if ($StoreSchedule->reschedule_date_3) {
                $reschedule_pm = $StoreSchedule->reschedule_date_3;
            } else if ($StoreSchedule->reschedule_date_2) {
                $reschedule_pm = $StoreSchedule->reschedule_date_2;
            } else if ($StoreSchedule->reschedule_date_1) {
                $reschedule_pm = $StoreSchedule->reschedule_date_1;
            }

            $StoreSchedule->schedule_next = $schedulenext;
            $StoreSchedule->machine_schedule_status = 1;
            if ($record_date->between($schedule_start, $schedule_end)) {
                $StoreSchedule->schedule_time_status = true;
            } else {
                if ($reschedule_pm) {
                    $record_planner = Carbon::parse($reschedule_pm);
                    if ($record_planner->eq($record_date)) {
                        $StoreSchedule->schedule_time_status = true;
                    } else {
                        $StoreSchedule->schedule_time_status = false;
                    }
                }
                $StoreSchedule->schedule_time_status = false;
            }
            $StoreSchedule->save();

            $monthly_id = ($StoreSchedule->monthly_id);
            $yearly_id = ($StoreSchedule->yearly_id);

            $this->checkstatusmonth($monthly_id);
            $this->checkstatusyear($yearly_id);

            return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Error!!!! Checklist failed to add. ' . $e->getMessage()]);
        }
    }

    private function checkstatusmonth($monthly_id) {
        $CheckSchedule = MonthlySchedule::find($monthly_id);
        $schedulecount =  count(json_decode($CheckSchedule->schedule_collection));

        $recordscount = DB::table('monthly_schedules')
        ->select('monthly_schedules.*', 'machine_schedules.*')
        ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
        ->where('monthly_schedules.id', '=', $monthly_id)
        ->where('machine_schedules.machine_schedule_status', '=', 1)
        ->count();

        if ($schedulecount == $recordscount) {
            $CheckSchedule->schedule_status = true;
            $CheckSchedule->save();
        }
    }

    private function checkstatusyear($yearly_id) {
        $CheckSchedule = YearlySchedule::find($yearly_id);
        $machinecount =  count(json_decode($CheckSchedule->machine_collection));

        $recordscount = DB::table('yearly_schedules')
        ->select('yearly_schedules.*', 'machine_schedules.*')
        ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
        ->where('yearly_schedules.id', '=', $yearly_id)
        ->where('machine_schedules.machine_schedule_status', '=', 1)
        ->count();

        if ($machinecount == $recordscount) {
            $CheckSchedule->schedule_status = true;
            $CheckSchedule->save();
        }
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
                ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.record_date as preventive_date')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->orderBy('machinerecords.id', 'desc')
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
        try {
            $request->validate([
                'correct_by' => 'required'
            ]);

            $currenttime = Carbon::now('Asia/Jakarta');
            $clear_abnormal = $request->input('clear_abnormals');

            $StoreRecords = Machinerecord::find($id);

            if (!$StoreRecords) {
                return response()->json(['error' => 'Record not found !!!!'], 404);
            } else if ($StoreRecords->correct_by) {
                return response()->json(['error' => 'Pembaruan data gagal. Data sudah dikoreksi oleh orang lain.'], 422);
            } else {
                $updateData = [
                    'correct_by' => $request->input('correct_by'),
                    'note' => $request->input('note'),
                    'finish_preventive' => $currenttime,
                ];
                if ($clear_abnormal == 1) {
                    $updateData['machinerecord_status'] = true;
                }
                $StoreRecords->update($updateData);
            }

            return response()->json(['success' => 'Data Preventive was successfully ACCEPTED']);
        } catch (\Exception $e) {
            Log::error(' update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }

    // fungsi untuk menghapus preventive mesin (HATI-HATI FUNGSI INI DIBUAT UNTUK BERJAGA-JAGA JIKA ADA MASALAH PADA APLIKASI) [admin only]
    public function deletecorrection($id) {
        try {
            $DeleteRecords = Machinerecord::find($id);
            $DeleteRecords->delete();
            return response()->json(['success' => 'Record deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record.'], 500);
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
                ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.record_date as preventive_date')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->orderBy('machinerecords.id', 'desc')
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
                ->select('machinerecords.id_machine_schedule', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'machine_schedules.yearly_id as year_id')
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
        try{
            $request->validate([
                'approve_by' => 'required'
            ]);
            $machine_id = $request->input('machine_id');

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
            else if ($machine_id) {
                $this->createabnormalmachine($machine_id);

                $machinerecord->update([
                    'approve_by' => $request->input('approve_by'),
                    'note' => $request->input('note'),
                    'machinerecord_status' => true,
                ]);
            } else {
                $machinerecord->update([
                    'approve_by' => $request->input('approve_by'),
                    'note' => $request->input('note')
                ]);
            }
            return response()->json(['success' => 'Data Preventive was successfully ACCEPTED']);
        } catch (\Exception $e) {
            Log::error(' update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }

    private function createabnormalmachine($machine_id)
    {
        $UpdateMachine = Machine::find($machine_id);
        $UpdateMachine->machine_abnormal = true;
        $UpdateMachine->save();
    }

    // fungsi untuk menghapus preventive mesin (HATI-HATI FUNGSI INI DIBUAT UNTUK BERJAGA-JAGA JIKA ADA MASALAH PADA APLIKASI) [admin only]
    public function deleteapproval($id) {
        try {
            $DeleteRecords = Machinerecord::find($id);
            $DeleteRecords->delete();
            return response()->json(['success' => 'Record deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record.'], 500);
        }
    }
    // <<<============================================================================================>>>
    // <<<===============================batas approval machine records===============================>>>
    // <<<============================================================================================>>>
}
