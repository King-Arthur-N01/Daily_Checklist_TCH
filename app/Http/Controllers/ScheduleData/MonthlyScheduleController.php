<?php

namespace App\Http\Controllers\ScheduleData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\MonthlySchedule;
use App\YearlySchedule;
use App\Machine;
use App\MachineSchedule;
use App\WorkingHour;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class MonthlyScheduleController extends Controller
{
    use HasPermissions, HasRoles;

    public function viewdataschedule($id)
    {
        try {
            $findSchedule = MonthlySchedule::where('id', $id)->first();

            $isSpecialSchedule = $findSchedule->schedule_special;

            if ($isSpecialSchedule == false) {
                $monthlyscheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->get();
            } else if ($isSpecialSchedule == true) {
                $monthlyscheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id') //bedakan disini !!!
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->get();
            }

            return response()->json(['monthlyscheduledata' => $monthlyscheduledata]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function findmachineabnormaldata()
    {
        try {
            $getmachines = Machine::where('machine_abnormal_status', true)->get();
            return response()->json([
                'getmachines' => $getmachines
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function readscheduleyeardata($id)
    {
        try {
            $machinescheduledata = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as machinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('yearly_schedules.id', '=', $id)
                ->orderBy('machine_schedules.schedule_start', 'asc')
                ->get();

            $workinghourdata = WorkingHour::get();

            return response()->json([
                'machinescheduledata' => $machinescheduledata,
                'workinghourdata' => $workinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function findschedulemonth($id)
    {
        try {
            $monthlyscheduledata = MonthlySchedule::find($id);
            $workinghourdata = WorkingHour::get();
            $machinescheduledata = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as machinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->orderBy('yearly_schedules.id', 'desc')
                ->get();

            return response()->json([
                'monthlyscheduledata' => $monthlyscheduledata,
                'workinghourdata' => $workinghourdata,
                'machinescheduledata' => $machinescheduledata
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function createschedulemonth(Request $request)
    {
        try {
            $request->validate([
                'name_schedule' => 'required',
                'schedule_date' => 'required|array',
            ]);
            // dd($request->all());
            $name_schedule = $request->input('name_schedule');
            $id_schedule = $request->input('id_schedule_year');
            $create_by = $request->input('schedule_create');
            // $schedule_duration = $request->input('schedule_duration', []);
            $schedule_date = $request->input('schedule_date', []);
            $schedule_key = $request->input('machine_schedule_id', []);

            // Validasi jumlah elemen pada kedua array
            if (count($schedule_date) !== count($schedule_key)) {
                return response()->json(['error' => 'Mismatch between machines and schedule ids'], 400);
            }

            $check_monthly_status = MonthlySchedule::where('id_schedule_year', $id_schedule)->latest('id')->first();
            // dd($check_monthly_status);
            if (!$check_monthly_status) {
                // No previous planner status found
            } else {
                if ($check_monthly_status->schedule_recognize === null) {
                    return response()->json(['error' => 'Schedule sebelum nya belum dicek oleh PLANNER!!!.'], 422);
                }
            }

            $StoreSchedule = new MonthlySchedule();
            $StoreSchedule->name_schedule_month = $name_schedule;
            $StoreSchedule->schedule_create = $create_by;
            $StoreSchedule->schedule_collection = json_encode($schedule_key);
            $StoreSchedule->id_schedule_year = $id_schedule;
            $StoreSchedule->save();

            $getmonthlyid = $StoreSchedule->id;

            foreach ($schedule_key as $index => $key) {
                $StoreMachineSchedule = MachineSchedule::find($key);
                // $StoreMachineSchedule->schedule_duration = $schedule_duration[$index];
                $StoreMachineSchedule->schedule_date = Carbon::createFromFormat('d-m-Y', $schedule_date[$index])->format('Y-m-d');
                $StoreMachineSchedule->monthly_id = $getmonthlyid;
                $StoreMachineSchedule->save();
            }

            return response()->json(['success' => 'Schedule mesin berhasil di TAMBAHKAN!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error creating data'], 500);
        }
    }

    public function updatechedulemonth(Request $request, $id)
    {
        try {
            $request->validate([
                'name_schedule' => 'required',
            ]);
            // dd($request->all());
            $name_schedule = $request->input('name_schedule');
            // $schedule_duration = $request->input('schedule_duration', []);
            $schedule_date = $request->input('schedule_date', []);
            $schedule_key = $request->input('machine_schedule_id', []);

            // Validasi jumlah elemen pada kedua array
            if (count($schedule_key) !== count($schedule_date)) {
                return response()->json(['error' => 'Mismatch between machines and schedule ids'], 400);
            }

            // Ambil data ID MachineSchedule berdasarkan monthly_id yang ada
            $previous_schedule_ids = DB::table('monthly_schedules')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->where('monthly_schedules.id', '=', $id)
                ->pluck('machine_schedules.id')
                ->toArray();

            // Tentukan ID yang perlu dihapus
            $delete_unused_ids = array_diff($previous_schedule_ids, $schedule_key);

            // Hapus semua value MachineSchedule->monthy_id yang tidak memiliki hubungan dengan monthly_schedules di request terbaru
            foreach ($delete_unused_ids as $delete_id) {
                $DeleteMachineSchedule = MachineSchedule::find($delete_id);
                $DeleteMachineSchedule->monthly_id = null;
                $DeleteMachineSchedule->save();
            }

            $UpdateSchedule = MonthlySchedule::find($id);
            $UpdateSchedule->name_schedule_month = $name_schedule;
            // $UpdateSchedule->schedule_create = $create_by;
            $UpdateSchedule->schedule_collection = json_encode($schedule_key);
            $UpdateSchedule->save();

            $schedule_id = $UpdateSchedule->id;

            foreach ($schedule_key as $index => $key) {
                $UpdateMachineSchedule = MachineSchedule::find($key) ?? new MachineSchedule();
                // $UpdateMachineSchedule->schedule_duration = $schedule_duration[$index];
                $UpdateMachineSchedule->schedule_date = Carbon::createFromFormat('d-m-Y', $schedule_date[$index])->format('Y-m-d');
                $UpdateMachineSchedule->monthly_id = $schedule_id;
                $UpdateMachineSchedule->save();
            }

            return response()->json(['success' => 'Schedule mesin berhasil di UPDATE!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error creating data'], 500);
        }
    }

    public function printdataschedulemonth($id)
    {
        try {
            $findSchedule = MonthlySchedule::where('id', $id)->first();

            $isSpecialSchedule = $findSchedule->schedule_special;

            if ($isSpecialSchedule == 0) {
                $scheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->orderBy('machine_schedules.schedule_date', 'asc')
                ->get();
            } else if ($isSpecialSchedule == 1) {
                $scheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->orderBy('machine_schedules.schedule_date', 'asc')
                ->get();
            }
            $workinghourdata = WorkingHour::get();

            // Ambil data schedule
            $firstSchedule = $scheduledata->first();
            $schedule_create = $firstSchedule ? $firstSchedule->schedule_create : null;
            $schedule_recognize = $firstSchedule ? $firstSchedule->schedule_recognize : null;
            $schedule_agreed = $firstSchedule ? $firstSchedule->schedule_agreed : null;

            // Ambil nama pengguna dengan pemeriksaan
            $user_create = DB::table('users')->select('name')->where('id', $schedule_create)->first();
            $user_recognize = DB::table('users')->select('name')->where('id', $schedule_recognize)->first();
            $user_agreed = DB::table('users')->select('name')->where('id', $schedule_agreed)->first();

            // Gunakan null coalescing untuk menghindari error
            $user_create_name = $user_create->name ?? 'Belum Ada';
            $user_recognize_name = $user_recognize->name ?? 'Belum Ada';
            $user_agreed_name = $user_agreed->name ?? 'Belum Ada';

            // Render PDF
            $pdf = PDF::loadView('dashboard.view_schedulemesin.printschedulemonth', compact('scheduledata', 'workinghourdata', 'user_create_name', 'user_recognize_name', 'user_agreed_name'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function deleteschedulemonth($id)
    {
        try {
            $DeleteSchedule = MonthlySchedule::find($id);
            $DeleteSchedule->delete();
            return response()->json(['success' => 'Schedule mesin berhasil di HAPUS!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error delete data'], 500);
        }
    }

    public function readschedulemonthdata($id) //global function untuk accept dan planner month
    {
        try{
            $findSchedule = MonthlySchedule::where('id', $id)->first();

            $isSpecialSchedule = $findSchedule->schedule_special;

            if ($isSpecialSchedule == false) {
                $scheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->orderBy('machine_schedules.schedule_date', 'asc')
                ->get();
            } else if ($isSpecialSchedule == true) {
                $scheduledata = DB::table('monthly_schedules')
                ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('monthly_schedules.id', '=', $id)
                ->orderBy('machine_schedules.schedule_date', 'asc')
                ->get();
            }

            $workinghourdata = WorkingHour::get();

            return response()->json([
                'scheduledata' => $scheduledata,
                'workinghourdata' => $workinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function refreshtableschedulemonth()
    {
        try {
            $refreshschedule = MonthlySchedule::get();
            return response()->json([
                'refreshschedule' => $refreshschedule
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }



    // <<<============================================================================================>>>
    // <<<==================================batas accept schedule=====================================>>>
    // <<<============================================================================================>>>

    public function indexschedulemonthaccept()
    {
        return view('dashboard.view_schedulemesin.tableacceptmonth');
    }

    // public function refreshtablescheduleagreed()
    // {
    //     try {
    //         $refreshschedule = MonthlySchedule::get();
    //         return response()->json([
    //             'refreshschedule' => $refreshschedule
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['error' => 'Error fetching data'], 500);
    //     }
    // }

    public function registermonthaccept(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'accept_by' => 'required'
            ]);

            $accept_by = $request->input('accept_by');

            // Temukan jadwal berdasarkan ID
            $StoreSchedule = MonthlySchedule::find($id);

            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            }

            // Check user permissions
            $user = auth()->user(); // Ambil pengguna yang sedang login
            Log::info('User  permissions: ', $user->getAllPermissions()->toArray());

            if ($user->hasPermissionTo('recognize_schedule')) {
                $StoreSchedule->schedule_recognize = $accept_by;
                $StoreSchedule->save();
            }

            if ($user->hasPermissionTo('agreed_schedule') && $user->hasPermissionTo('recognize_schedule')) {
                $StoreSchedule->schedule_recognize = $accept_by;
                $StoreSchedule->schedule_agreed = $accept_by;
                $StoreSchedule->save();
            }

            return response()->json(['success' => 'Data schedule berhasil di TERIMA!']);
        } catch (\Exception $e) {
            Log::error('Update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data: ' . $e->getMessage()], 500);
        }
    }

    // <<<============================================================================================>>>
    // <<<================================batas accept schedule end===================================>>>
    // <<<============================================================================================>>>



    // <<<============================================================================================>>>
    // <<<==================================batas schedule planner====================================>>>
    // <<<============================================================================================>>>

    public function indexschedulemonthplanner()
    {
        return view('dashboard.view_schedulemesin.tableplannermonth');
    }

    public function refreshtablescheduleplanner()
    {
        try {
            $refreshschedule = MonthlySchedule::whereNotNull('schedule_agreed')->get();
            return response()->json([
                'refreshschedule' => $refreshschedule
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function registerplanner(Request $request, $id)
    {
        try {
            // dd($request)->all();
            $request->validate([
                'planned_by' => 'required'
            ]);
            $StoreSchedule = MonthlySchedule::find($id);
            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            }

            // Cek izin pengguna
            $user = auth()->user(); // Ambil pengguna yang sedang login

            if ($user->hasPermissionTo('reschedule_schedule')) {
                $StoreSchedule->schedule_planner = $request->input('planned_by');
                $StoreSchedule->save();
            } else {
                return response()->json(['error' => 'The user does not have the required permissions !!!!'], 422);
            }

            $machine_reschedule = $request->input('reschedule_id');
            foreach ($machine_reschedule as $key => $reschedule) {
                $StoreMachineSchedule = MachineSchedule::find($reschedule);
                $reschedule_hour = $request->input('reschedule_hour')[$key];
                $reschedule_value = $request->input('reschedule_value')[$key];
                $reschedule_note = $request->input('reschedule_note')[$key];

                if ($StoreMachineSchedule) {
                    if ($reschedule_value != null) {
                        $reschedule_date = Carbon::createFromFormat('d-m-Y', $reschedule_value)->format('Y-m-d');
                        if ($StoreMachineSchedule->reschedule_date_1 == null) {
                            $StoreMachineSchedule->reschedule_date_1 = $reschedule_date;
                        } else if ($StoreMachineSchedule->reschedule_date_2 == null) {
                            $StoreMachineSchedule->reschedule_date_2 = $reschedule_date;
                        } else if ($StoreMachineSchedule->reschedule_date_3 == null) {
                            $StoreMachineSchedule->reschedule_date_3 = $reschedule_date;
                        } else {
                            return response()->json(['error' => 'Tidak bisa lebih dari 3x melakukan RESCHEDULE!!! '], 422);
                        }
                    }
                    $StoreMachineSchedule->schedule_hour = $reschedule_hour;
                    $StoreMachineSchedule->reschedule_note = $reschedule_note;
                    $StoreMachineSchedule->save();
                } else {
                    return response()->json(['error' => 'Machine schedule not found for ID: ' . $reschedule], 404);
                }
            }
            return response()->json(['success' => 'Schedule mesin berhasil di TERIMA!']);
        } catch (\Exception $e) {
            Log::error('update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }

    // <<<============================================================================================>>>
    // <<<================================batas schedule planner end==================================>>>
    // <<<============================================================================================>>>



    // <<<============================================================================================>>>
    // <<<==================================batas special schedule====================================>>>
    // <<<============================================================================================>>>

    public function readspecialscheduledata($id)
    {
        try {
            $specialscheduledata = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as machinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('yearly_schedules.id', '=', $id)
                ->orderBy('machine_schedules.schedule_start', 'asc')
                ->get();

            $workinghourdata = WorkingHour::get();

            return response()->json([
                'specialscheduledata' => $specialscheduledata,
                'workinghourdata' => $workinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    // public function readmachinespecialdata()
    // {
    //     try {
    //         // $machinedata = Machine::get();
    //         $machinedata = DB::table('machines')
    //         ->select('id','invent_number','machine_number','machine_name','machine_brand','machine_type','machine_spec','machine_info');

    //         return DataTables::of($machinedata)->make(true);
    //     } catch (\Exception $e) {
    //         Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
    //         return response()->json(['error' => 'An unexpected error occurred'], 500);
    //     }
    // }

    public function createspecialschedule(Request $request)
    {
        try {
            // dd($request)->all();
            $request->validate([
                'name_schedule' => 'required',
                'schedule_date' => 'required|array',
            ]);
            // dd($request->all());
            $name_schedule = $request->input('name_schedule');
            $id_schedule = $request->input('id_schedule_year');
            $create_by = $request->input('schedule_create');
            // $schedule_duration = $request->input('schedule_duration', []);
            $schedule_date = $request->input('schedule_date', []);
            $schedule_key = $request->input('machine_schedule_id', []);

            // Validasi jumlah elemen pada kedua array
            if (count($schedule_date) !== count($schedule_key)) {
                return response()->json(['error' => 'Mismatch between machines and schedule ids'], 400);
            }

            $StoreSchedule = new MonthlySchedule();
            $StoreSchedule->name_schedule_month = $name_schedule;
            $StoreSchedule->schedule_create = $create_by;
            $StoreSchedule->schedule_collection = json_encode($schedule_key);
            $StoreSchedule->id_schedule_year = $id_schedule;
            $StoreSchedule->schedule_special = true;
            $StoreSchedule->save();

            $getspecialid = $StoreSchedule->id;

            foreach ($schedule_key as $index => $key) {
                $StoreMachineSchedule = MachineSchedule::find($key);
                // $StoreMachineSchedule->schedule_duration = $schedule_duration[$index];
                $StoreMachineSchedule->schedule_date = Carbon::createFromFormat('d-m-Y', $schedule_date[$index])->format('Y-m-d');
                $StoreMachineSchedule->special_id = $getspecialid;
                $StoreMachineSchedule->save();
            }

            return response()->json(['success' => 'Special schedule mesin berhasil di TAMBAHKAN!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error creating data'], 500);
        }
    }

    // <<<============================================================================================>>>
    // <<<================================batas special schedule end==================================>>>
    // <<<============================================================================================>>>
}
