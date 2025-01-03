<?php

namespace App\Http\Controllers\ScheduleData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\MonthlySchedule;
use App\YearlySchedule;
use App\Machine;
use App\MachineSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MonthlyScheduleController extends Controller
{
    public function refreshtablescheduleagreed()
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

    public function readscheduleyeardata($id)
    {
        try {
            $getmachines = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as machinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

            return response()->json([
                'getmachines' => $getmachines,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function findschedulemonth($id)
    {
        try {
            $refreshschedule = MonthlySchedule::find($id);

            $getmachines = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as getmachinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->orderBy('yearly_schedules.id', 'desc')
                ->get();

            return response()->json([
                'refreshschedule' => $refreshschedule,
                'getmachines' => $getmachines
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
            $schedule_duration = $request->input('schedule_duration', []);
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
                $StoreMachineSchedule->schedule_duration = $schedule_duration[$index];
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

            $name_schedule = $request->input('name_schedule');
            $schedule_duration = $request->input('schedule_duration', []);
            $schedule_date = $request->input('schedule_date', []);
            $update_machine_ids = $request->input('machine_schedule_id', []);
            $machine_key = $request->input('machine_id', []);

            // Validasi jumlah elemen pada kedua array
            if (count($machine_key) !== count($schedule_date)) {
                return response()->json(['error' => 'Mismatch between machines and schedule ids'], 400);
            }

            // Ambil data ID MachineSchedule berdasarkan monthly_id yang ada
            $previous_machine_ids = DB::table('monthly_schedules')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->where('monthly_schedules.id', '=', $id)
                ->pluck('machine_schedules.id')
                ->toArray();

            // Tentukan ID yang perlu dihapus
            $delete_unused_ids = array_diff($previous_machine_ids, $update_machine_ids);

            // Hapus semua value MachineSchedule->monthy_id yang tidak memiliki hubungan dengan monthly_schedules di request terbaru
            foreach ($delete_unused_ids as $delete_id) {
                $DeleteMachineSchedule = MachineSchedule::find($delete_id);
                $DeleteMachineSchedule->monthly_id = null;
                $DeleteMachineSchedule->save();
            }

            $UpdateSchedule = MonthlySchedule::find($id);
            $UpdateSchedule->name_schedule_month = $name_schedule;
            $UpdateSchedule->machine_collection2 = json_encode($machine_key);
            $UpdateSchedule->save();

            $schedule_id = $UpdateSchedule->id;

            foreach ($update_machine_ids as $index => $key) {
                $UpdateMachineSchedule = MachineSchedule::find($key) ?? new MachineSchedule();
                $UpdateMachineSchedule->schedule_duration = $schedule_duration[$index];
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

    public function viewdataschedule($id)
    {
        try {
            $getschedulemonth = DB::table('monthly_schedules')
            ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->where('monthly_schedules.id', '=', $id)
            ->get();

            return response()->json(['getschedulemonth' => $getschedulemonth]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function printdataschedulemonth($id)
    {
        try {
            $scheduledata = DB::table('monthly_schedules')
            ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->where('monthly_schedules.id', '=', $id)
            ->get();

            // Render PDF
            $pdf = PDF::loadView('dashboard.view_schedulemesin.printschedulemonth', compact('scheduledata'));
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

    // <<<============================================================================================>>>
    // <<<==================================batas ketahui schedule====================================>>>
    // <<<============================================================================================>>>

    public function indexschedulemonthrecognize()
    {
        return view('dashboard.view_schedulemesin.tablerecognizemonth');
    }

    public function findscheduledata($id)
    {
        try{
            $scheduledata = DB::table('monthly_schedules')
            ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->where('monthly_schedules.id', '=', $id)
            ->get();

            return response()->json([
                'scheduledata' => $scheduledata
            ]);
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function registerrecognize(Request $request, $id)
    {
        try {
            $request->validate([
                'recognize_by' => 'required'
            ]);
            // dd($request->all());
            $StoreSchedule = MonthlySchedule::find($id);
            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            } else {
                $StoreSchedule->schedule_recognize = $request->input('recognize_by');
                $StoreSchedule->save();
            }

            $machine_reschedule = $request->input('machine_reschedule');
            if ($machine_reschedule) {
                foreach ($machine_reschedule as $reschedule) {
                    $StoreMachineSchedule = MachineSchedule::find($reschedule['schedule_id']);
                    if ($StoreMachineSchedule) {
                        $reschedule_date = Carbon::createFromFormat('d-m-Y', $reschedule['reschedule_value'])->format('Y-m-d');
                        if ($StoreMachineSchedule->reschedule_date_1 == null) {
                            $StoreMachineSchedule->reschedule_date_1 = $reschedule_date;
                        } else if ($StoreMachineSchedule->reschedule_date_2 == null) {
                            $StoreMachineSchedule->reschedule_date_2 = $reschedule_date;
                        } else if ($StoreMachineSchedule->reschedule_date_3 == null) {
                            $StoreMachineSchedule->reschedule_date_3 = $reschedule_date;
                        } else {
                            return response()->json(['error' => 'Tidak bisa lebih dari 3x melakukan RESCHEDULE!!! '], 422);
                        }
                        $StoreMachineSchedule->reschedule_note = $reschedule['reschedule_note'];
                        $StoreMachineSchedule->save();
                    } else {
                        return response()->json(['error' => 'Machine schedule not found for ID: ' . $reschedule['schedule_id']], 404);
                    }
                }
            } else {
                return response()->json(['error' => 'No reschedule data provided'], 400);
            }
            return response()->json(['success' => 'Schedule mesin berhasil di TERIMA!']);
        } catch (\Exception $e) {
            Log::error('update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }


    // <<<============================================================================================>>>
    // <<<================================batas ketahui schedule end==================================>>>
    // <<<============================================================================================>>>



    // <<<============================================================================================>>>
    // <<<==================================batas setujui schedule====================================>>>
    // <<<============================================================================================>>>
    public function indexschedulemonthagreed()
    {
        return view('dashboard.view_schedulemesin.tableagreedmonth');
    }

    public function registermonthagreed(Request $request, $id)
    {
        try {
            $request->validate([
                'agreed_by' => 'required'
            ]);

            $StoreSchedule = MonthlySchedule::find($id);

            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            } else if ($StoreSchedule->schedule_agreed) {
                return response()->json(['error' => 'Pembaruan data gagal. Data sudah disetujui oleh orang lain.'], 422);
            } else {
                $StoreSchedule->schedule_agreed = $request->input('agreed_by');
                $StoreSchedule->save();
            }
            return response()->json(['success' => 'Data Schedule was successfully ACCEPTED']);
        } catch (\Exception $e) {
            Log::error(' update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }

    // <<<============================================================================================>>>
    // <<<================================batas setujui schedule end==================================>>>
    // <<<============================================================================================>>>
}
