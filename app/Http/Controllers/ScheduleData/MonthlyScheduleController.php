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

class MonthlyScheduleController extends Controller
{
    public function readscheduleyeardata($id)
    {
        try {
            $getmachines = DB::table('yearly_schedules')
                ->select('machine_schedules.*', 'machines.*', 'machine_schedules.id as getmachinescheduleid')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

            return response()->json([
                'getmachines' => $getmachines,
                'getscheduleid',
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
            $name_schedule = $request->input('name_schedule');
            $id_schedule = $request->input('id_schedule_year');
            $schedule_duration = $request->input('schedule_duration', []);
            $schedule_date = $request->input('schedule_date', []);
            $schedule_key = $request->input('machine_schedule_id', []);
            $machine_key = $request->input('machine_id', []);

            // Validasi jumlah elemen pada kedua array
            if (count($machine_key) !== count($schedule_key)) {
                return response()->json(['error' => 'Mismatch between machines and schedule ids'], 400);
            }

            $StoreSchedule = new MonthlySchedule();
            $StoreSchedule->name_schedule_month = $name_schedule;
            $StoreSchedule->machine_collection2 = json_encode($machine_key);
            $StoreSchedule->id_schedule_year = $id_schedule;
            $StoreSchedule->save();

            $getmonthlyid = MonthlySchedule::latest('id')->first()->id;

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
            $getscheduledetail = DB::table('monthly_schedules')
            ->select('monthly_schedules.*', 'machine_schedules.*', 'machines.*')
            ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->where('monthly_schedules.id', '=', $id)
            ->get();

            return response()->json(['getscheduledetail' => $getscheduledetail]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MonthlySchedule  $monthlySchedule
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlySchedule $monthlySchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MonthlySchedule  $monthlySchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(MonthlySchedule $monthlySchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MonthlySchedule  $monthlySchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlySchedule $monthlySchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MonthlySchedule  $monthlySchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlySchedule $monthlySchedule)
    {
        //
    }
}
