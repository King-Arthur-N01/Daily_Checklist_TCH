<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Schedule;
use App\Machine;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmachineschedule()
    {
        return view ('dashboard.view_schedulemesin.tableschedule');
    }

    public function refreshtableschedule()
    {
        try {
            $refreshmachine = Machine::all();
            $refreshschedule= Schedule::all();
            return response()->json([
                'refreshmachine' => $refreshmachine,
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

    public function detailmachineschedule($id)
    {
        try {
            $refreshmachine = Machine::find($id);
            return response()->json([
                'refreshmachine' => $refreshmachine
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function createschedule(Request $request)
    {
        $currenttime = Carbon::today();
        $checkmachineid = Schedule::where('id_machine2', $request->id_machine2)->first();
        try {
            $preventivetime = $request->input('schedule_time');
            $nextpreventive = $currenttime->addMonths($preventivetime);
            if (!$checkmachineid){
                $StoreSchedule = new Schedule();
                $StoreSchedule->id_machine2 = $request->input('id_machine2');
                $StoreSchedule->schedule_time = $request->input('schedule_time');
                $StoreSchedule->schedule_next = $nextpreventive;
                $StoreSchedule->save();
            } else {
                return response()->json(['error' => 'Mesin Sudah memiliki jadwal preventive !!!!'], 500);
            }
            return response()->json(['success' => 'Waktu preventive mesin berhasil di UPDATE!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
