<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Schedule;
use App\Machine;
use App\MachineSchedule;
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
    public function indexschedule()
    {
        return view('dashboard.view_schedulemesin.tableschedule');
    }

    public function formmachineschedule($id)
    {
        $getschedule = Schedule::find($id);
        $machinearray = json_decode($getschedule->id_machine, true);
        $getmachineid = [];

        foreach ($machinearray as $eachmachineid){
            $machine = Machine::find($eachmachineid);
            $getmachineid[] = $machine;
        }

        return view('dashboard.view_schedulemesin.formschedulemesin', [
            'getschedule' => $getschedule,
            'getmachineid' => $getmachineid,
        ]);
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

    public function readdatamachine()
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

    public function readdataschedule($id)
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
            $id_machine_array = json_encode($request->input('id_machine'));
            $StoreSchedule = new Schedule();
            $StoreSchedule->name_schedule = $request->input('name_schedule');
            $StoreSchedule->id_machine = $id_machine_array;
            $StoreSchedule->save();

            return response()->json(['success' => 'Schedule mesin berhasil di TAMBAHKAN!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error adding data'], 500);
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
