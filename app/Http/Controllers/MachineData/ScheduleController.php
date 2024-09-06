<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Schedule;
use App\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmachineschedule()
    {
        return view('dashboard.view_schedulemesin.tableschedule');
    }

    public function refreshtableschedule()
    {
        try {
            // $refreshmachine = Machine::all();
            $refreshschedule= Schedule::all();
            return response()->json([
                'refreshschedule' => $refreshschedule,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // untuk test fecth data dummy calendar
    Public function datacalendar() {
        $data = [
            [
                'id' => '1',
                'title' => 'WELDING CO2 MANUAL',
                'start' => '2024-08-01',
                'end' => '2024-08-07'
            ],
            [
                'id' => '2',
                'title' => 'WELDING ROBOT',
                'start' => '2024-07-07',
                'end' => '2024-08-14'
            ],
            [
                'id' => '3',
                'title' => 'SCREW COMPRESSORE',
                'start' => '2024-08-26',
                'end' => '2024-08-31'
            ],
            [
                'id' => '4',
                'title' => 'POWER PRESS',
                'start' => '2024-09-01',
                'end' => '2024-09-10'
            ]
        ];
        return response()->json($data);
    }

    public function fetchmachinedata()
    {
        try {
            $refreshmachine = Machine::all();
            return response()->json([
                'refreshmachine' => $refreshmachine
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function fetchmachinedataid($id)
    {
        try {
            $getschedule = Schedule::find($id);
            $machinearray = json_decode($getschedule->id_machine, true);
            $refreshmachine = Machine::all();
            return response()->json([
                'getschedule' => $getschedule,
                'machinearray' => $machinearray,
                'refreshmachine' => $refreshmachine
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function createschedule(Request $request)
    {
        try {
            $currenttime = Carbon::today();
            $scheduletime = $request->input('schedule_time');
            $schedulenext = $currenttime->addMonths($scheduletime);
            $id_machine_array = explode(',', $request->input('id_machine'));
            $StoreSchedule = new Schedule();
            $StoreSchedule->schedule_name = $request->input('schedule_name');
            $StoreSchedule->schedule_time = $request->input('schedule_time');
            $StoreSchedule->id_machine = json_encode($id_machine_array);
            $StoreSchedule->schedule_next = $schedulenext;
            $StoreSchedule->save();

            // $combinemachine = $request->input('id_machine');
            // $splitmachine = explode(',', $combinemachine);
            // foreach ($splitmachine as $eachmachineid){
            //     $UpdateMachine = Machine::where('id', $eachmachineid)->first();
            //     if($scheduletime == 1){
            //         $UpdateMachine->schdule_1_month = $schedulenext;
            //     }elseif($scheduletime == 3){
            //         $UpdateMachine->schdule_3_month = $schedulenext;
            //     }elseif($scheduletime == 6){
            //         $UpdateMachine->schdule_6_month = $schedulenext;
            //     }elseif($scheduletime == 12){
            //         $UpdateMachine->schdule_12_month = $schedulenext;
            //     }
            //     $UpdateMachine->save();
            // }
            return response()->json(['success' => 'Schedule mesin berhasil di TAMBAHKAN!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error adding data'], 500);
        }
    }

    public function updateschedule(Request $request, $id)
    {
        try {
            $currenttime = Carbon::today();
            $scheduletime = $request->input('schedule_time');
            $schedulenext = $currenttime->addMonths($scheduletime);
            $id_machine_array = explode(',', $request->input('id_machine'));
            $UpdateSchedule = Schedule::find($id);

            // $machinejson = $UpdateSchedule->id_machine;
            // $machinearray = json_decode($machinejson, true);
            // foreach ($machinearray as $eachmachineid){
            //     $UpdateMachine = Machine::where('id', $eachmachineid)->first();
            //     if($scheduletime == 1){
            //         $UpdateMachine->schdule_1_month = null;
            //     }elseif($scheduletime == 3){
            //         $UpdateMachine->schdule_3_month = null;
            //     }elseif($scheduletime == 6){
            //         $UpdateMachine->schdule_6_month = null;
            //     }elseif($scheduletime == 12){
            //         $UpdateMachine->schdule_12_month = null;
            //     }
            //     $UpdateMachine->save();
            // }

            $UpdateSchedule->schedule_name = $request->input('schedule_name');
            $UpdateSchedule->schedule_time = $request->input('schedule_time');
            $UpdateSchedule->id_machine = json_encode($id_machine_array); // change into json string array to save in one column
            $UpdateSchedule->schedule_next = $schedulenext;
            $UpdateSchedule->save();

            // $combinemachine = $request->input('id_machine');
            // $splitmachine = explode(',', $combinemachine);
            // foreach ($splitmachine as $eachmachineid){
            //     $UpdateMachine = Machine::where('id', $eachmachineid)->first();
            //     if($scheduletime == 1){
            //         $UpdateMachine->schdule_1_month = $schedulenext;
            //     }elseif($scheduletime == 3){
            //         $UpdateMachine->schdule_3_month = $schedulenext;
            //     }elseif($scheduletime == 6){
            //         $UpdateMachine->schdule_6_month = $schedulenext;
            //     }elseif($scheduletime == 12){
            //         $UpdateMachine->schdule_12_month = $schedulenext;
            //     }
            //     $UpdateMachine->save();
            // }
            return response()->json(['success' => 'Schedule mesin berhasil di UPDATE!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error updating data'], 500);
        }
    }

    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    public function deleteschedule($id)
    {
        try{
            $DeleteSchedule = Schedule::where('id', $id);
            $DeleteSchedule->delete();
            return response()->json(['success' => 'Schedule mesin berhasil di HAPUS!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error delete data'], 500);
        }
    }
}
