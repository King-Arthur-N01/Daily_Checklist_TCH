<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Machineschedule;
use App\Schedule;
use App\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachinescheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function readdataschedule($id)
    {
        try {
            $schedule = Schedule::find($id);
            $machinearray = json_decode($schedule->machine_collection, true);
            $getmachines = [];

            foreach ($machinearray as $eachmachineid) {
                $machineid = Machine::where('id', $eachmachineid)->get();
                $getmachines[] = $machineid;
            }
            return response()->json([
                'getmachines' => $getmachines,
                'getschedule' => $id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // public function readdatamachineschedule($id)
    // {
    //     try {
    //         $getschedule = Schedule::find($id);
    //         $machinearray = json_decode($getschedule->id_machine, true);
    //         $getmachineid = [];

    //         foreach ($machinearray as $eachmachineid){
    //             $machine = Machine::find($eachmachineid);
    //             $getmachineid[] = $machine;
    //         }
    //         return response()->json([
    //             'getschedule' => $getschedule,
    //             'getmachineid' => $getmachineid,
    //             'schedule_id' => $id
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error fetching data'], 500);
    //     }
    // }

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
                $StoreSchedule = new Machineschedule;
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


    // public function createmachineschedule(Request $request)
    // {
    //     try {
    //         $id_schedule = $request->input('id_schedule');
    //         $machinekey = $request->input('id_machine',[]);
    //         foreach ($machinekey as $key => $index) {
    //             $scheduleStart = $request->input('schedule_time')[$key];
    //             $scheduleEnd = Carbon::parse($scheduleStart)->addDays(7);

    //             $StoreSchedule = new Machineschedule;
    //             $StoreSchedule->schedule_start = $scheduleStart;
    //             $StoreSchedule->schedule_end = $scheduleEnd;
    //             $StoreSchedule->id_machine3 = $index;
    //             $StoreSchedule->id_schedule = $id_schedule;
    //             $StoreSchedule->save();
    //         }
    //         return response()->json(['success' => 'Schedule mesin berhasil di UPDATE!']);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['error' => 'Error updating data'], 500);
    //     }
    // }

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
     * @param  \App\Machineschedule  $machineschedule
     * @return \Illuminate\Http\Response
     */
    public function show(Machineschedule $machineschedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Machineschedule  $machineschedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Machineschedule $machineschedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Machineschedule  $machineschedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machineschedule $machineschedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Machineschedule  $machineschedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machineschedule $machineschedule)
    {
        //
    }
}
