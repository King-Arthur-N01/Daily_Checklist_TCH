<?php

namespace App\Http\Controllers\ScheduleData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\YearlySchedule;
use App\Machine;
use App\MachineSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YearlyScheduleController extends Controller
{
    public function indexschedule()
    {
        return view('dashboard.view_schedulemesin.tableschedule');
    }

    public function formmachinescheduleNOTUSE($id)
    {
        $getschedule = YearlySchedule::find($id);
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
            $refreshschedule= YearlySchedule::all();
            return response()->json([
                'refreshschedule' => $refreshschedule,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function refreshdetailtableschedule($id)
    {
        try {
            $refreshscheduledetail = DB::table('yearly_schedules')
                ->select('monthly_schedules.*', 'yearly_schedules.id', 'monthly_schedules.id as getmonthid')
                ->join('monthly_schedules', 'yearly_schedules.id', '=', 'monthly_schedules.id_schedule_year')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.monthly_id')
                ->groupBy('monthly_schedules.id')
                ->selectRaw('count(machine_schedules.monthly_id) as machine_count')
                ->where('yearly_schedules.id', '=', $id)
                ->get();
            return response()->json([
                'refreshscheduledetail' => $refreshscheduledetail,
                'getmonthid' => $refreshscheduledetail->pluck('getmonthid'),
                'machine_count' => $refreshscheduledetail->pluck('machine_count')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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

    public function readmachinedata()
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

    public function findschedule($id)
    {
        try {
            $refreshschedule = YearlySchedule::find($id);
            $refreshmachine = Machine::all();

            $refreshmachineschedule = DB::table('yearly_schedules')
            ->select('yearly_schedules.id', 'machine_schedules.*')
            ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
            ->where('yearly_schedules.id', '=', $id)
            ->get();

            return response()->json([
                'refreshschedule' => $refreshschedule,
                'refreshmachine' => $refreshmachine,
                'refreshmachineschedule' => $refreshmachineschedule
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    // public function readdataschedule($id)
    // {
    //     try {
    //         $getschedule = Schedule::find($id);
    //         $machinearray = json_decode($getschedule->id_machine, true);
    //         $refreshmachine = Machine::all();
    //         return response()->json([
    //             'getschedule' => $getschedule,
    //             'machinearray' => $machinearray,
    //             'refreshmachine' => $refreshmachine
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error fetching data'], 500);
    //     }
    // }

    public function createschedule(Request $request)
    {
        try {
            $request->validate([
                'name_schedule' => 'required',
            ]);

            $machine_keys = $request->input('id_machine');
            $schedule_times = $request->input('schedule_time');

            // Ensure both arrays have the same number of elements
            if (count($machine_keys) !== count($schedule_times)) {
                return response()->json(['error' => 'Mismatch between machines and schedule times'], 400);
            }

            $StoreSchedule = new YearlySchedule();
            $StoreSchedule->name_schedule_year = $request->input('name_schedule');
            $StoreSchedule->machine_collection = json_encode($machine_keys);
            $StoreSchedule->save();

            $schedule_id = YearlySchedule::latest('id')->first()->id;

            foreach ($machine_keys as $index => $key) {
                $ScheduleTimeRange = $request->input('schedule_time')[$index];
                list($ScheduleStart, $ScheduleEnd) = explode(' - ', $ScheduleTimeRange);

                $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
                $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

                $StoreMachineSchedule = new MachineSchedule();
                $StoreMachineSchedule->schedule_start = $ScheduleStartCarbon;
                $StoreMachineSchedule->schedule_end = $ScheduleEndCarbon;
                $StoreMachineSchedule->machine_id = $key;
                $StoreMachineSchedule->yearly_id = $schedule_id;
                $StoreMachineSchedule->save();
            }

            return response()->json(['success' => 'Schedule mesin berhasil di TAMBAHKAN!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error adding data'], 500);
        }
    }


    public function updateschedule(Request $request, $id)
    {
        try {
            // dd($request);
            $request->validate([
                'name_schedule_edit' => 'required',
            ]);

            $machine_keys = $request->input('id_machine');
            $schedule_times = $request->input('schedule_time');

            // Ensure both arrays have the same number of elements
            if (count($machine_keys) !== count($schedule_times)) {
                return response()->json(['error' => 'Mismatch between machines and schedule times'], 400);
            }

            $UpdateSchedule = YearlySchedule::find($id);
            $UpdateSchedule->name_schedule_year = $request->input('name_schedule_edit');
            $UpdateSchedule->machine_collection = json_encode($machine_keys);
            $UpdateSchedule->save();

            $schedule_id = $UpdateSchedule->id;

            foreach ($machine_keys as $index => $key) {
                $ScheduleTimeRange = $request->input('schedule_time')[$index];
                list($ScheduleStart, $ScheduleEnd) = explode(' - ', $ScheduleTimeRange);

                $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
                $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

                $UpdateMachineSchedule = MachineSchedule::find($key);
                $UpdateMachineSchedule->schedule_start = $ScheduleStartCarbon;
                $UpdateMachineSchedule->schedule_end = $ScheduleEndCarbon;
                $UpdateMachineSchedule->machine_id = $key;
                $UpdateMachineSchedule->yearly_id = $schedule_id;
                $UpdateMachineSchedule->save();
            }
            return response()->json(['success' => 'Schedule mesin berhasil di UPDATE!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error updating data'], 500);
        }
    }

    public function deleteschedule($id)
    {
        try {
            $DeleteSchedule = YearlySchedule::find($id);
            $DeleteSchedule->delete();
            return response()->json(['success' => 'Schedule mesin berhasil di HAPUS!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error delete data'], 500);
        }
    }
}
