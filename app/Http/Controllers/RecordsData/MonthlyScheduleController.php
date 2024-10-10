<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
            // dd($request);
            $schedule_duration = $request->input('schedule_duration', []);
            $schedule_date = $request->input('schedule_date', []);
            $schedulekey = $request->input('id_schedule2', []);

            // Loop through each machine key and create a Machineschedule record
            foreach ($schedulekey as $index => $key) {
                $StoreSchedule = new MonthlySchedule;
                $StoreSchedule->schedule_duration = $schedule_duration[$index];
                $StoreSchedule->schedule_date = Carbon::createFromFormat('d-m-Y', $schedule_date[$index])->format('Y-m-d');
                $StoreSchedule->id_schedule2 = $key;
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
