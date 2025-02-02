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
use App\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class MachinerecordController extends Controller
{
    use HasPermissions, HasRoles;
    // fungsi untuk permission
    // public function __construct(){
    //     $this->middleware('permission:#namapermission#', ['only' => ['#namafunction#']]);
    // }

    // fungsi untuk melihat table preventive mesin
    public function indexpreventive()
    {
        return view('dashboard.view_recordmesin.tablerecordmesin');
    }


    // fungsi menampilkan tabel dan merefresh tabel preventive
    public function refreshtablepreventive()
    {
        try {
            $refreshpreventive = DB::table('yearly_schedules')
            ->select('yearly_schedules.*', DB::raw('COUNT(DISTINCT machine_schedules.id) as machine_schedules_count'))
            ->leftJoin('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
            ->groupBy('yearly_schedules.id')
            ->get();

            return response()->json([
                'refreshpreventive' => $refreshpreventive,
                'machine_schedules_count' => $refreshpreventive->pluck('machine_schedules_count'),
            ]);
        } catch (\Exception $e) {
            Log::error('fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function refreshdetailtablepreventive($id)
    {
        try {
            $refreshdetailpreventive = DB::table('yearly_schedules')
            ->select('monthly_schedules.*', 'yearly_schedules.id', 'monthly_schedules.id as getmonthid')
            ->join('monthly_schedules', 'yearly_schedules.id', '=', 'monthly_schedules.id_schedule_year')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->groupBy('monthly_schedules.id')
            ->selectRaw('count(machine_schedules.monthly_id) as machine_count')
            ->where('yearly_schedules.id', '=', $id)
            ->where('monthly_schedules.schedule_planner', '=', !null)
            ->get();

            return response()->json([
                'refreshdetailpreventive' => $refreshdetailpreventive,
                'getmonthid' => $refreshdetailpreventive->pluck('getmonthid'),
                'machine_count' => $refreshdetailpreventive->pluck('machine_count')
            ]);
        } catch (\Exception $e) {
            Log::error('fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function readscheduledata($id)
    {
        try {
            // Data berdasarkan schedule
            $baseonscheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.name_schedule_month', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->get();

            // Ambil ID dari baseonscheduledata untuk filter
            $baseonScheduleIds = $baseonscheduledata->pluck('schedule_id')->toArray();

            // Data Off Schedule
            $offscheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->whereNotNull('monthly_schedules.schedule_planner')
                ->where('monthly_schedules.schedule_status', '=', 0)
                ->get();

            // Data Pending Schedule
            $pendingscheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.schedule_special', '=', 0)
                ->where('monthly_schedules.schedule_status', '=', 0)
                ->whereNotNull('monthly_schedules.schedule_planner')
                ->whereNotIn('machine_schedules.id', $baseonScheduleIds) // Hindari duplikasi
                ->get();

            // Data Working Hour
            $workinghourdata = WorkingHour::all();

            return response()->json([
                'baseonscheduledata' => $baseonscheduledata,
                'offscheduledata' => $offscheduledata,
                'pendingscheduledata' => $pendingscheduledata,
                'workinghourdata' => $workinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }



    public function readoffscheduledata($id)
    {
        try {
            $offscheduledata = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as machinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

            $workinghourdata = WorkingHour::get();

            return response()->json([
                'offscheduledata' => $offscheduledata,
                'workinghourdata' => $workinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function printdatarecord($id)
    {
        try{
            $machinedata = DB::table('machinerecords')
                ->select('machinerecords.machine_schedule_id', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machine_schedules', 'machinerecords.machine_schedule_id', '=', 'machine_schedules.id')
                ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->leftJoin('machineproperties', 'machines.property_id', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $preventivedata = DB::table('machinerecords')
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'machinerecords.id as record_id')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $usernames = json_decode($preventivedata->first()->create_by);

            $combineresult[] = [
                'operator_action' => $preventivedata->first()->operator_action,
                'result' => $preventivedata->first()->result
            ];

            // Render PDF
            $pdf = PDF::loadView('dashboard.view_history.printrecord', compact(['machinedata', 'preventivedata', 'combineresult', 'usernames']));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi tampilan formulir untuk mengisi preventive mesin (record mesin)
    public function formpreventive($id)
    {
        try {
            $users = User::get();
            $timenow = Carbon::now();

            $joinmachine = DB::table('machine_schedules')
            ->select('machine_schedules.*', 'machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*', 'machine_schedules.id as getscheduleid', 'machines.id as getmachineid')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->join('machineproperties', 'machines.property_id', '=', 'machineproperties.id')
            ->join('componenchecks', 'componenchecks.id_property', '=', 'machineproperties.id')
            ->join('parameters', 'parameters.id_componencheck', '=', 'componenchecks.id')
            ->join('metodechecks', 'metodechecks.id_parameter', '=', 'parameters.id')
            ->where('machine_schedules.id', '=', $id)
            ->get();
            // dd($joinmachine);

            if ($joinmachine->isEmpty()) {
                // Return an error message or a default view
                return view('dashboard.view_blockpage.404', ['message' => 'No machine record found.']);
            }
            return view('dashboard.view_recordmesin.formrecordmesin', [
                'joinmachine' => $joinmachine,
                'timenow' => $timenow,
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Error!!!! Checklist failed to add. ' . $e->getMessage()]);
        }
    }

    // fungsi meregister hasil formulir preventive mesin (record mesin) ke dalam database
    public function createpreventive(Request $request)
    {
        try {
            // dd($request)->all();
            $machine_id = $request->input('machine_id');
            $schedule_id = $request->input('schedule_id');
            $problem = $request->input('problem');
            $cause = $request->input('cause');
            $action = $request->input('action');
            $status = $request->input('status');
            $target = $request->input('target');
            $create_by_json = $request->input('combined_create_by');
            $operator_action_json = json_encode(array_values($request->input('operator_action')));
            $result_json = json_encode(array_values($request->input('result')));

            $record_date = Carbon::parse($request->input('record_date'));
            $currenttime = Carbon::now('Asia/Jakarta');

            $current_shift_time = Carbon::now()->format('H:i');
            if ($current_shift_time >= '07:00' && $current_shift_time < '15:59') {
                $shifttime = 'Shift 1';
            } elseif ($current_shift_time >= '16:00' && $current_shift_time < '23:59') {
                $shifttime = 'Shift 2';
            } else {
                $shifttime = 'Diluar Shift Atau Lembur';
            }

            $PreviousAbnormalExist = Machinerecord::where('machine_id', $machine_id)->where('machinerecord_status', 2)->latest()->first();

            // Ambil data lama jika ada
            $previous_problem_value = $PreviousAbnormalExist->problem ?? '';
            $previous_cause_value = $PreviousAbnormalExist->cause ?? '';
            $previous_action_value = $PreviousAbnormalExist->action ?? '';
            $previous_status_value = $PreviousAbnormalExist->status ?? '';
            $previous_target_value = $PreviousAbnormalExist->target ?? '';

            $StoreRecords = new Machinerecord();
            $StoreRecords->shift = $shifttime;
            $StoreRecords->note = $request->input('note');
            $StoreRecords->machine_id = $machine_id;
            $StoreRecords->machine_schedule_id = $schedule_id;
            $StoreRecords->operator_action = $operator_action_json;
            $StoreRecords->result = $result_json;
            $StoreRecords->create_by = $create_by_json;
            $StoreRecords->record_date = $record_date;
            $StoreRecords->start_preventive = $currenttime;

            // PERATURAN STATUS RECORD YANG ADA PADA COLUMN "machinerecord_status"
            // 0 = RECORD OPEN
            // 1 = RECORD CLOSE
            // 2 = RECORD ABNORMAL

            if ($problem == null && $cause == null && $action == null && $status == null && $target == null) {
                $StoreRecords->problem = trim($problem . " | " . $previous_problem_value, " | ");
                $StoreRecords->cause = trim($cause . " | " . $previous_cause_value, " | ");
                $StoreRecords->action = trim($action . " | " . $previous_action_value, " | ");
                $StoreRecords->status = trim($status . " | " . $previous_status_value, " | ");
                $StoreRecords->target = trim($target . " | " . $previous_target_value, " | ");
                $StoreRecords->machinerecord_status = 0;
                $StoreRecords->finish_preventive = $currenttime;
            } else {
                // Gabungkan data baru dengan data lama menggunakan separator
                $StoreRecords->problem = trim($problem . " | " . $previous_problem_value, " | ");
                $StoreRecords->cause = trim($cause . " | " . $previous_cause_value, " | ");
                $StoreRecords->action = trim($action . " | " . $previous_action_value, " | ");
                $StoreRecords->status = trim($status . " | " . $previous_status_value, " | ");
                $StoreRecords->target = trim($target . " | " . $previous_target_value, " | ");
                $StoreRecords->machinerecord_status = 2;
                $StoreRecords->finish_preventive = null;
                $this->createabnormalmachine($machine_id);
            }
            $StoreRecords->save();

            $StoreSchedule = Machineschedule::find($schedule_id);
            // PERATURAN STATUS SCHEDULE YANG ADA PADA COLUMN "machine_schedule_status"
            // 1 = RECORD SUDAH DIKERJAKAN
            // 2 = RECORD SUDAH DIKERJAKAN TETAPI TERDAPAT ABONORMALITY
            if ($StoreSchedule) {
                $StoreSchedule->machine_schedule_status = $problem == null ? 1 : 2;
                $StoreSchedule->schedule_record = $record_date;
                $StoreSchedule->save();
            } else {
                Log::error("Schedule not found for ID: " . $schedule_id);
            }

            $monthly_id = $StoreSchedule->monthly_id;

            $this->checkstatusmonth($monthly_id);
            return redirect()->route("indexpreventive")->withSuccess('Checklist added successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Error!!!! Checklist failed to add. ' . $e->getMessage()]);
        }
    }

    private function createabnormalmachine($machine_id)
    {
        $UpdateMachine = Machine::find($machine_id);
        $UpdateMachine->machine_abnormal_status = true;
        $UpdateMachine->save();
    }

    private function checkstatusmonth($monthly_id) {
        $CheckSchedule = MonthlySchedule::find($monthly_id);
        $isSpecialSchedule = $CheckSchedule->schedule_special;
        $schedulecount =  count(json_decode($CheckSchedule->schedule_collection));

        if ($isSpecialSchedule == false) {
            $recordscount = DB::table('monthly_schedules')
            ->select('monthly_schedules.*', 'machine_schedules.*')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->where('monthly_schedules.id', '=', $monthly_id)
            ->where('machine_schedules.machine_schedule_status', '=', 1)
            ->count();
        } else if ($isSpecialSchedule == true) {
            $recordscount = DB::table('monthly_schedules')
            ->select('monthly_schedules.*', 'machine_schedules.*')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id')
            ->where('monthly_schedules.id', '=', $monthly_id)
            ->where('machine_schedules.machine_schedule_status', '=', 1)
            ->count();
        }

        if ($schedulecount == $recordscount) {
            $CheckSchedule->schedule_status = true;
            $CheckSchedule->save();
        }
    }

    private function checkstatusspecial($monthly_id) {
        $CheckSchedule = MonthlySchedule::find($monthly_id);
        $schedulecount =  count(json_decode($CheckSchedule->schedule_collection));

        $recordscount = DB::table('monthly_schedules')
        ->select('monthly_schedules.*', 'machine_schedules.*')
        ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id')
        ->where('monthly_schedules.id', '=', $monthly_id)
        ->where('machine_schedules.machine_schedule_status', '=', 1)
        ->count();

        if ($schedulecount == $recordscount) {
            $CheckSchedule->schedule_status = true;
            $CheckSchedule->save();
        }
    }

    // private function checkstatusyear($yearly_id) {
    //     $CheckSchedule = YearlySchedule::find($yearly_id);
    //     $machinecount =  count(json_decode($CheckSchedule->machine_collection));

    //     $recordscount = DB::table('yearly_schedules')
    //     ->select('yearly_schedules.*', 'machine_schedules.*')
    //     ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
    //     ->where('yearly_schedules.id', '=', $yearly_id)
    //     ->where('machine_schedules.machine_schedule_status', '=', 1)
    //     ->count();

    //     if ($machinecount == $recordscount) {
    //         $CheckSchedule->schedule_status = true;
    //         $CheckSchedule->save();
    //     }
    // }

    public function formeditpreventive($id)
    {
        try {
            $preventivedata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'machinerecords.id as record_id', 'machine_schedules.id as schedule_id')
            ->leftJoin('machine_schedules', 'machinerecords.machine_schedule_id', '=', 'machine_schedules.id')
            ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->leftJoin('machineproperties', 'machines.property_id', '=', 'machineproperties.id')
            ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machine_schedules.id', '=', $id)
            ->get();

            $user_operator = $preventivedata->first()->create_by;

            $combineresult[] = [
                'operator_action' => $preventivedata->first()->operator_action,
                'result' => $preventivedata->first()->result
            ];


            if ($preventivedata->isEmpty()) {
                // Return an error message or a default view
                return view('dashboard.view_blockpage.404', ['message' => 'No machine record found.']);
            }
            return view('dashboard.view_recordmesin.formeditrecordmesin', [
                'preventivedata' => $preventivedata,
                'combineresult' => $combineresult,
                'user_operator' => $user_operator,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Error!!!! Checklist failed to add. ' . $e->getMessage()]);
        }
    }

    public function updatepreventive(Request $request, $id)
    {
        try {
            // dd($request)->all();
            $note = $request->input('note');
            $problem = $request->input('problem');
            $cause = $request->input('cause');
            $action = $request->input('action');
            $status = $request->input('status');
            $target = $request->input('target');

            $currenttime = Carbon::now('Asia/Jakarta');

            $UpdateMachineRecord = Machinerecord::find($id);

            $machine_id = $UpdateMachineRecord->machine_id;
            $schedule_id = $UpdateMachineRecord->machine_schedule_id ;

            // PERATURAN STATUS RECORD YANG ADA PADA COLUMN "machinerecord_status"
            // 0 = RECORD OPEN
            // 1 = RECORD CLOSE
            // 2 = RECORD ABNORMAL

            $UpdateMachineRecord->note = $note;
            $UpdateMachineRecord->problem = $problem;
            $UpdateMachineRecord->cause = $cause;
            $UpdateMachineRecord->action = $action;
            $UpdateMachineRecord->status = $status;
            $UpdateMachineRecord->target = $target;
            $UpdateMachineRecord->machinerecord_status = 1;
            $UpdateMachineRecord->finish_preventive = $currenttime;
            $UpdateMachineRecord->fix_abnormal_date = $currenttime;
            $UpdateMachineRecord->save();

            // $MachineStatus = Machine::find('id', $machine_id);
            // $abnormal_status = $MachineStatus->machine_abnormal_status;
            // if ($abnormal_status == true) {
            //     $this->updateabnormalmachine($machine_id);
            // }

            $UpdateSchedule = Machineschedule::find($schedule_id);
            $monthly_id = $UpdateSchedule->monthly_id;
            $special_id = $UpdateSchedule->special_id;

            $UpdateSchedule->machine_schedule_status = 1;
            $UpdateSchedule->save();

            if ($special_id == !null) {
                $this->checkstatusspecial($special_id);
            }
            $this->checkstatusmonth($monthly_id);
            $this->updateabnormalmachine($machine_id);

            return redirect()->route("indexpreventive")->withSuccess('Checklist Update successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Error!!!! Checklist failed to add. ' . $e->getMessage()]);
            // return response()->json(['message' => 'Error!!!! Checklist failed to add. ' . $e->getMessage()], 500);
        }
    }

    private function updateabnormalmachine($machine_id)
    {
        $UpdateMachine = Machine::find($machine_id);
        $UpdateMachine->machine_abnormal_status = false;
        $UpdateMachine->save();
    }


    // <<<============================================================================================>>>
    // <<<================================batas accept machine records================================>>>
    // <<<============================================================================================>>>

    // index tampilan untuk koreksi preventive mesin [supervisor + ass.manager + manager only]
    public function indexpreventiveaccept()
    {
        return view('dashboard.view_recordmesin.tableacceptrecord');
    }

    public function refreshtablepreventiveaccept()
    {
        try {
            $refreshrecord = DB::table('machinerecords')
                ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id')
                ->join('machines', 'machinerecords.machine_id', '=', 'machines.id')
                ->join('machine_schedules', 'machinerecords.machine_schedule_id', '=', 'machine_schedules.id')
                ->orderBy('machinerecords.id', 'desc')
                ->get();

            return response()->json([
                'refreshrecord' => $refreshrecord
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi $ajax untuk mengambil detail data mesin + hasil preventive mesin dari database untuk disetujui
    public function readpreventivedata($id)
    {
        try{
            $machinedata = DB::table('machinerecords')
                ->select('machinerecords.machine_schedule_id', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machine_schedules', 'machinerecords.machine_schedule_id', '=', 'machine_schedules.id')
                ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->leftJoin('machineproperties', 'machines.property_id', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $preventivedata = DB::table('machinerecords')
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'machinerecords.id as record_id')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $combineresult[] = [
                'operator_action' => $preventivedata->first()->operator_action,
                'result' => $preventivedata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'preventivedata' => $preventivedata,
                'combineresult' => $combineresult
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    // fungsi untuk mensetujui dan meregister hasil preventive mesin [supervisor + ass.manager + manager only]
    public function registerpreventiveccept(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'accept_by' => 'required',
            ]);

            $accept_by = $request->input('accept_by');

            // Temukan jadwal berdasarkan ID
            $StoreRecords = Machinerecord::find($id);

            if (!$StoreRecords) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            }

            $check_status_abnormal = $StoreRecords->machinerecord_status;

            // Cek izin pengguna
            $user = auth()->user(); // Ambil pengguna yang sedang login

            if ($user->hasPermissionTo('corrected_record')) {
                $StoreRecords->correct_by = $accept_by;
                $StoreRecords->note = $request->input('note');
                $StoreRecords->problem = $request->input('problem');
                $StoreRecords->cause = $request->input('cause');
                $StoreRecords->action = $request->input('action');
                $StoreRecords->status = $request->input('status');
                $StoreRecords->target = $request->input('target');
                $StoreRecords->status = $request->input('status');
                if ($check_status_abnormal == 0) {
                    $StoreRecords->machinerecord_status = 1;
                } else {
                    $StoreRecords->machinerecord_status = 2;
                }
                $StoreRecords->save();
            }

            if ($user->hasPermissionTo('approval_record') && $user->hasPermissionTo('corrected_record')) {
                $StoreRecords->correct_by = $accept_by;
                $StoreRecords->approve_by = $accept_by; // Bedakan disini !!!!
                $StoreRecords->note = $request->input('note');
                $StoreRecords->problem = $request->input('problem');
                $StoreRecords->cause = $request->input('cause');
                $StoreRecords->action = $request->input('action');
                $StoreRecords->status = $request->input('status');
                $StoreRecords->target = $request->input('target');
                $StoreRecords->status = $request->input('status');
                if ($check_status_abnormal == 0) {
                    $StoreRecords->machinerecord_status = 1;
                } else {
                    $StoreRecords->machinerecord_status = 2;
                }
                $StoreRecords->save();
            }

            return response()->json(['success' => 'Data Schedule was successfully ACCEPTED']);
        } catch (\Exception $e) {
            Log::error(' update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }

    // fungsi untuk menghapus preventive mesin (HATI-HATI FUNGSI INI DIBUAT UNTUK BERJAGA-JAGA JIKA ADA MASALAH PADA APLIKASI) [admin only]
    public function deleteaccept($id) {
        try {
            $DeleteRecords = Machinerecord::find($id);
            $DeleteRecords->correct_by = null;
            $DeleteRecords->approve_by = null;
            return response()->json(['success' => 'Record deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record.'], 500);
        }
    }
    // <<<============================================================================================>>>
    // <<<================================batas accept machine records================================>>>
    // <<<============================================================================================>>>


    // <<<============================================================================================>>>
    // <<<===============================batas history machine records================================>>>
    // <<<============================================================================================>>>

    // fungsi untuk melihat history preventive mesin
    public function indexhistoryrecord()
    {
        return view('dashboard.view_history.tablehistory');
    }

    // fungsi menampilkan tabel dan merefresh tabel history preventice
    public function refreshtablehistory()
    {
        $joinrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machine_schedules.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.record_date as preventive_date', 'machinerecords.correct_by as getcorrect', 'machinerecords.approve_by as getapprove')
            ->join('machine_schedules', 'machinerecords.machine_schedule_id', '=', 'machine_schedules.id')
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
                ->select('machinerecords.machine_schedule_id', 'machine_schedules.machine_id', 'machines.*', 'machineproperties.id', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
                ->leftJoin('machine_schedules', 'machinerecords.machine_schedule_id', '=', 'machine_schedules.id')
                ->leftJoin('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->leftJoin('machineproperties', 'machines.property_id', '=', 'machineproperties.id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machinerecords.id', '=', $id)
                ->get();

            $preventivedata = DB::table('machinerecords')
                ->select('machinerecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name', 'machinerecords.id as record_id')
                ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
                ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
                ->where('machinerecords.id', '=', $id)
                ->get();


            $combineresult[] = [
                'operator_action' => $preventivedata->first()->operator_action,
                'result' => $preventivedata->first()->result
            ];

            return response()->json([
                'machinedata' => $machinedata,
                'preventivedata' => $preventivedata,
                'combineresult' => $combineresult,
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // <<<============================================================================================>>>
    // <<<==============================batas history machine records end=============================>>>
    // <<<============================================================================================>>>
}
