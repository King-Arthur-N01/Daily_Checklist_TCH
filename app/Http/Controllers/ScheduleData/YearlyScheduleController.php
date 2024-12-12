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
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class YearlyScheduleController extends Controller
{
    public function indexschedule()
    {
        return view('dashboard.view_schedulemesin.tableschedule');
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

    public function readmachinedata()
    {
        try {
            $refreshmachine = Machine::all()->filter(function ($machine) {
                return $machine->machine_status == true; // Atau bisa juga menggunakan $machine->machine_status === 1
            });
            return response()->json([
                'refreshmachine' => $refreshmachine->values() // values() untuk mengatur ulang kunci array
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
            ->select('yearly_schedules.id', 'machine_schedules.*', 'machine_schedules.id as getmachinescheduleid')
            ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
            ->where('yearly_schedules.id', '=', $id)
            ->get();

            return response()->json([
                'refreshschedule' => $refreshschedule,
                'refreshmachine' => $refreshmachine,
                'refreshmachineschedule' => $refreshmachineschedule,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function viewdataschedule($id)
    {
        // Pass ID to the view for use in JavaScript
        return view('dashboard.view_schedulemesin.viewscheduleyear', compact('id'));
    }

    public function eventcalendar($id)
    {
        $schedule_data = DB::table('machine_schedules')
        ->select('machine_schedules.*', 'machines.*', 'machines.id as machine_id')
        ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
        ->where('machine_schedules.yearly_id', '=', $id)
        ->get();

        // Transform data for FullCalendar
        $events = $schedule_data->map(function ($schedule) {
            return [
                'resourceId' => $schedule->machine_id,
                'title' => $schedule->machine_number,
                'start' => Carbon::parse($schedule->schedule_start)->format('Y-m-d'),
                'end' => Carbon::parse($schedule->schedule_end)->format('Y-m-d'),
            ];
        });

        return response()->json($events);
    }

    public function resourcecalendar($id)
    {
        $schedule_data = DB::table('machine_schedules')
        ->select('machine_schedules.*', 'machines.*', 'machines.id as machine_id')
        ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
        ->where('machine_schedules.yearly_id', '=', $id)
        ->get();

        // Function to generate random hex color
        function generateColor() {
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        // Transform data for FullCalendar
        $events = $schedule_data->map(function ($schedule) {
            return [
                'id' => $schedule->machine_id,
                'title' => $schedule->machine_name,
                'eventColor' => generateColor(),
            ];
        });

        return response()->json($events);
    }

    public function printScheduleAnnual($id)
    {
        return $this->generatePDF('dashboard.view_schedulemesin.printscheduleyear', $id);
    }

    public function printScheduleQuarter1($id)
    {
        return $this->generatePDF('dashboard.view_schedulemesin.printschedulequarter1', $id);
    }

    public function printScheduleQuarter2($id)
    {
        return $this->generatePDF('dashboard.view_schedulemesin.printschedulequarter2', $id);
    }

    private function generatePDF($view, $id)
    {
        try {
            $scheduledata = DB::table('yearly_schedules')
                ->select('yearly_schedules.*', 'machine_schedules.*', 'machines.*', 'machine_schedules.id as schedule_id')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

            $recorddata = DB::table('yearly_schedules')
                ->select('yearly_schedules.id', 'machine_schedules.id', 'machinerecords.*', 'machine_schedules.id as record_id')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

            $pdf = PDF::loadView($view, compact(['scheduledata', 'recorddata']));
            $pdf->setPaper('A3', 'landscape');
            return $pdf->stream();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function createschedule(Request $request)
    {
        try {
            $request->validate([
                'name_schedule' => 'required',
            ]);

            $machine_key = $request->input('machine_id');
            $schedule_times = $request->input('schedule_time');

            // Validasi jumlah elemen pada kedua array
            if (count($machine_key) !== count($schedule_times)) {
                return response()->json(['error' => 'Mismatch between machines and schedule times'], 400);
            }

            $StoreSchedule = new YearlySchedule();
            $StoreSchedule->name_schedule_year = $request->input('name_schedule');
            $StoreSchedule->machine_collection = json_encode($machine_key);
            $StoreSchedule->save();

            $schedule_id = YearlySchedule::latest('id')->first()->id;

            foreach ($machine_key as $index => $key) {
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
            $request->validate([
                'name_schedule_edit' => 'required',
            ]);

            $machine_array = $request->input('machine_id');
            $update_machine_ids = $request->input('machine_schedule_id');
            $schedule_times = $request->input('schedule_time');

            // Validasi jumlah elemen pada kedua array
            if (count($machine_array) !== count($schedule_times)) {
                return response()->json(['error' => 'Mismatch between machines and schedule times'], 400);
            }

            // Ambil data ID MachineSchedule berdasarkan yearly_id yang ada
            $previous_machine_ids = DB::table('yearly_schedules')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->where('yearly_schedules.id', '=', $id)
                ->pluck('machine_schedules.id')
                ->toArray();

            // Tentukan ID yang perlu dihapus
            $delete_unused_ids = array_diff($previous_machine_ids, $update_machine_ids);

            // Hapus semua MachineSchedule yang tidak ada di request terbaru
            foreach ($delete_unused_ids as $delete_id) {
                $DeleteMachineSchedule = MachineSchedule::find($delete_id);
                $DeleteMachineSchedule->delete();
            }

            // Update YearlySchedule
            $UpdateSchedule = YearlySchedule::find($id);
            $UpdateSchedule->name_schedule_year = $request->input('name_schedule_edit');
            $UpdateSchedule->machine_collection = json_encode($machine_array);
            $UpdateSchedule->save();

            $schedule_id = $UpdateSchedule->id;

            // Update atau buat MachineSchedule baru
            foreach ($update_machine_ids as $index => $key) {
                $ScheduleTimeRange = $schedule_times[$index];
                list($ScheduleStart, $ScheduleEnd) = explode(' - ', $ScheduleTimeRange);

                $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
                $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

                // Temukan atau buat entri baru di MachineSchedule
                $UpdateMachineSchedule = MachineSchedule::find($key) ?? new MachineSchedule();
                $UpdateMachineSchedule->schedule_start = $ScheduleStartCarbon;
                $UpdateMachineSchedule->schedule_end = $ScheduleEndCarbon;
                $UpdateMachineSchedule->machine_id = $machine_array[$index]; // Use $index to get the correct machine_id
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
