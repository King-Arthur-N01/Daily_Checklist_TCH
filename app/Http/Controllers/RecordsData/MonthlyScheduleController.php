<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use App\MonthlySchedule;
use App\YearlySchedule;
use App\Schedule;
use App\Machine;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MonthlyScheduleController extends Controller
{
    public function readdataschedule($id)
    {
        try {

            $getmachines = DB::table('yearly_schedules')
                ->select('yearly_schedules.*', 'machines.*','yearly_schedules.id as getscheduleid')
                ->join('machines', 'yearly_schedules.id_machine', '=', 'machines.id')
                ->where('yearly_schedules.id_schedule', '=', $id)
                ->get();
            // dd($getmachines);

            return response()->json([
                'getmachines' => $getmachines,
                'getscheduleid',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function createschedulemonth(Request $request)
    {
        try {
            dd($request);
            $id_schedule = $request->input('id_schedule');
            $machinekey = $request->input('id_machine', []);
            $schedule_duration = $request->input('schedule_duration', []);
            $schedule_time = $request->input('schedule_time', []);

            // Ensure the number of machine keys matches the schedule durations and times
            if (count($machinekey) !== count($schedule_duration) || count($machinekey) !== count($schedule_time)) {
                return response()->json(['error' => 'Input array lengths do not match'], 400);
            }

            // Loop through each machine key and create a Machineschedule record
            foreach ($machinekey as $index => $key) {
                $StoreSchedule = new MonthlySchedule;
                $StoreSchedule->schedule_duration = $schedule_duration[$index];  // Assign individual duration
                $StoreSchedule->schedule_time = $schedule_time[$index];          // Assign individual time
                $StoreSchedule->id_schedule = $id_schedule;
                $StoreSchedule->id_machine2 = $key;  // Assuming 'id_machine2' refers to the machine's key
                $StoreSchedule->save();
            }

            return response()->json(['success' => 'Schedule mesin berhasil di TAMBAHKAN!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error creating data'], 500);
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
