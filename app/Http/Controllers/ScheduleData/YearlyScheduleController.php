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
            $refreshschedule = YearlySchedule::all();
            // $refreshmachine = Machine::get('machine_abnormal');
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
            Log::error($e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function readmachinedata()
    {
        try {
            // Ambil mesin yang aktif
            $refreshmachine = Machine::where('machine_status', true)->get();

            // Ambil jadwal terbaru untuk setiap mesin
            $latestSchedules = DB::table('machine_schedules')
                ->select('machine_schedules.*', 'machinerecords.*', 'machine_schedules.machine_id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->whereIn('machine_schedules.id', function($query) {
                    $query->select(DB::raw('MAX(id)'))
                          ->from('machine_schedules')
                          ->groupBy('machine_id');
                })
                ->get();

            return response()->json([
                'refreshmachine' => $refreshmachine,
                'latestSchedules' => $latestSchedules
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching machine data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function findschedule($id)
    {
        try {
            $refreshschedule = YearlySchedule::find($id);
            $refreshmachine = Machine::where('machine_status', true)->get();
            $latestSchedules = MachineSchedule::select('machine_id', DB::raw('MAX(created_at) as latest'))
                ->groupBy('machine_id')
                ->get();

            $latestScheduleDetails = [];
            foreach ($latestSchedules as $schedule) {
                $latestScheduleDetails[] = MachineSchedule::where('machine_id', $schedule->machine_id)
                    ->where('created_at', $schedule->latest)
                    ->first();
            }

            $refreshmachineschedule = DB::table('yearly_schedules')
            ->select('yearly_schedules.id', 'machine_schedules.*', 'machine_schedules.id as getmachinescheduleid')
            ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
            ->where('yearly_schedules.id', '=', $id)
            ->get();

            return response()->json([
                'refreshschedule' => $refreshschedule,
                'refreshmachine' => $refreshmachine,
                'refreshmachineschedule' => $refreshmachineschedule,
                'latestSchedules' => $latestScheduleDetails
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
                'title' => $schedule->invent_number,
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

    public function printscheduleannual($id)
    {
        return $this->generatePDF('dashboard.view_schedulemesin.printscheduleyear', $id);
    }

    public function printschedulequarter1($id)
    {
        return $this->generatePDF('dashboard.view_schedulemesin.printschedulequarter1', $id);
    }

    public function printschedulequarter2($id)
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
                ->groupBy('machine_schedules.id')
                ->get();

            $recorddata = DB::table('yearly_schedules')
                ->select('yearly_schedules.id', 'machine_schedules.id', 'machinerecords.*', 'machine_schedules.id as record_id')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machinerecords', 'machine_schedules.id', '=', 'machinerecords.id_machine_schedule')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

                // Ambil data schedule
                $firstSchedule = $scheduledata->first();
                $schedule_create = $firstSchedule ? $firstSchedule->schedule_create : null;
                $schedule_recognize = $firstSchedule ? $firstSchedule->schedule_recognize : null;
                $schedule_agreed = $firstSchedule ? $firstSchedule->schedule_agreed : null;

                // Ambil nama pengguna dengan pemeriksaan
                $user_create = DB::table('users')->select('name')->where('id', $schedule_create)->first();
                $user_recognize = DB::table('users')->select('name')->where('id', $schedule_recognize)->first();
                $user_agreed = DB::table('users')->select('name')->where('id', $schedule_agreed)->first();

                // Gunakan null coalescing untuk menghindari error
                $user_create_name = $user_create->name ?? 'Belum Ada';
                $user_recognize_name = $user_recognize->name ?? 'Belum Ada';
                $user_agreed_name = $user_agreed->name ?? 'Belum Ada';

            $pdf = PDF::loadView($view, compact(['scheduledata', 'recorddata', 'user_create_name', 'user_recognize_name', 'user_agreed_name']));
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
                'limit_schedule' => 'required|integer',
                'schedule_create' => 'required|integer',
                'schedule_time' => 'required|array',
                'machine_id' => 'required|array',
                'preventive_cycle' => 'required|array',
            ]);

            $machine_key = $request->input('machine_id');
            $schedule_times = $request->input('schedule_time');
            $preventive_cycles = $request->input('preventive_cycle');

            // Validasi jumlah elemen pada semua array
            if (count($machine_key) !== count($schedule_times) || count($machine_key) !== count($preventive_cycles)) {
                return response()->json(['error' => 'Mismatch between machines, schedule times, and preventive cycles'], 400);
            }

            $StoreSchedule = new YearlySchedule();
            $StoreSchedule->name_schedule_year = $request->input('name_schedule');
            $StoreSchedule->schedule_create = $request->input('schedule_create');
            $StoreSchedule->machine_collection = json_encode($machine_key);
            $StoreSchedule->save();

            $schedule_id = $StoreSchedule->id;
            $months_in_year = 12;

            foreach ($machine_key as $index => $key) {
                $ScheduleTimeRange = $schedule_times[$index];
                $ScheduleCycle = $preventive_cycles[$index];
                list($ScheduleStart, $ScheduleEnd) = explode(' - ', $ScheduleTimeRange);

                $result_in_year = $months_in_year / $ScheduleCycle;

                $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
                $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

                for ($i = 0; $i < $result_in_year; $i++) {
                    $new_schedule_start = $ScheduleStartCarbon->copy()->addMonths(($ScheduleCycle * $i));
                    $new_schedule_end = $ScheduleEndCarbon->copy()->addMonths(($ScheduleCycle * $i));

                    if ($new_schedule_start->year > $request->input('limit_schedule')) {
                        break; // Hentikan loop jika tahun mencapai limit_schedule
                    }

                    $StoreMachineSchedule = new MachineSchedule();
                    $StoreMachineSchedule->schedule_start = $new_schedule_start;
                    $StoreMachineSchedule->schedule_end = $new_schedule_end;
                    $StoreMachineSchedule->preventive_cycle = $ScheduleCycle;
                    $StoreMachineSchedule->machine_id = $key;
                    $StoreMachineSchedule->yearly_id = $schedule_id;
                    $StoreMachineSchedule->save();
                }
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
                'preventive_cycle' => 'required|array',
            ]);

            $machine_key = $request->input('machine_id');
            $schedule_times = $request->input('schedule_time');
            $preventive_cycles = $request->input('preventive_cycle');


            // Validasi jumlah elemen pada semua array
            if (count($machine_key) !== count($schedule_times) || count($machine_key) !== count($preventive_cycles)) {
                return response()->json(['error' => 'Mismatch between machines, schedule times, and preventive cycles'], 400);
            }

            $yearly_schedule = YearlySchedule::find($id);

            if ($yearly_schedule->schedule_recognize !== null) {
                return response()->json(['error' => 'Tidak bisa update schedule. Schedule sudah dikoreksi dan disetujui.!!'], 422);
            }
            // Ambil data ID MachineSchedule berdasarkan machine_id yang ada
            $previous_machine = json_decode($yearly_schedule->machine_collection);

            // Hapus semua MachineSchedule yang tidak ada di request terbaru
            foreach ($previous_machine as $delete_machine) {
                $DeleteMachineSchedule = MachineSchedule::where('machine_id', $delete_machine)->where('yearly_id', $id);
                $DeleteMachineSchedule->delete();
            }

            // Update YearlySchedule
            $UpdateSchedule = YearlySchedule::find($id);
            $UpdateSchedule->name_schedule_year = $request->input('name_schedule_edit');
            $UpdateSchedule->machine_collection = json_encode($machine_key);
            $UpdateSchedule->save();

            $schedule_id = $UpdateSchedule->id;
            $months_in_year = 12;

            foreach ($machine_key as $index => $key) {
                $ScheduleTimeRange = $schedule_times[$index];
                $ScheduleCycle = $preventive_cycles[$index];
                list($ScheduleStart, $ScheduleEnd) = explode(' - ', $ScheduleTimeRange);

                $result_in_year = $months_in_year / $ScheduleCycle;

                $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
                $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

                for ($i = 0; $i < $result_in_year; $i++) {
                    $new_schedule_start = $ScheduleStartCarbon->copy()->addMonths(($ScheduleCycle * $i));
                    $new_schedule_end = $ScheduleEndCarbon->copy()->addMonths(($ScheduleCycle * $i));

                    if ($new_schedule_start->year > $request->input('limit_schedule')) {
                        break; // Hentikan loop jika tahun mencapai limit_schedule
                    }

                    $StoreMachineSchedule = new MachineSchedule();
                    $StoreMachineSchedule->schedule_start = $new_schedule_start;
                    $StoreMachineSchedule->schedule_end = $new_schedule_end;
                    $StoreMachineSchedule->preventive_cycle = $ScheduleCycle;
                    $StoreMachineSchedule->machine_id = $key;
                    $StoreMachineSchedule->yearly_id = $schedule_id;
                    $StoreMachineSchedule->save();
                }
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
            if ($DeleteSchedule->schedule_recognize !== null) {
                return response()->json(['error' => 'Tidak bisa hapus schedule. Schedule sudah dikoreksi dan disetujui.!!'], 422);
            }
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

    public function indexschedulerecognize()
    {
        return view('dashboard.view_schedulemesin.tablerecognizeyear');
    }

    public function readscheduledata($id)
    {
        try{
            $scheduledata = DB::table('machine_schedules')
            ->select('machine_schedules.*', 'machines.*', 'machines.id as machine_id')
            ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
            ->where('machine_schedules.yearly_id', '=', $id)
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

            $StoreSchedule = YearlySchedule::find($id);

            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            } else if ($StoreSchedule->schedule_recognize) {
                return response()->json(['error' => 'Pembaruan data gagal. Data sudah diketahui oleh orang lain.'], 422);
            } else {
                $StoreSchedule->schedule_recognize = $request->input('recognize_by');
                $StoreSchedule->save();
            }
            return response()->json(['success' => 'Data Schedule was successfully ACCEPTED']);
        } catch (\Exception $e) {
            Log::error(' update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }


    // <<<============================================================================================>>>
    // <<<================================batas ketahui schedule end==================================>>>
    // <<<============================================================================================>>>




    // <<<============================================================================================>>>
    // <<<==================================batas setujui schedule====================================>>>
    // <<<============================================================================================>>>

    public function indexscheduleagreed()
    {
        return view('dashboard.view_schedulemesin.tableagreedyear');
    }

    public function registeragreed(Request $request, $id)
    {
        try {
            $request->validate([
                'agreed_by' => 'required'
            ]);

            $StoreSchedule = YearlySchedule::find($id);

            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            } else if (!$StoreSchedule->schedule_recognize) {
                return response()->json(['error' => 'Pembaruan data gagal. Data belum diketahui oleh orang lain.'], 422);
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
