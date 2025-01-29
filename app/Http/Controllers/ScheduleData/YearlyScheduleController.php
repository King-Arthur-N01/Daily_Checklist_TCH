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
use Spatie\Permission\Traits\HasPermissions;

class YearlyScheduleController extends Controller
{
    use HasPermissions;

    public function indexschedule()
    {
        return view('dashboard.view_schedulemesin.tableschedule');
    }

    public function refreshtableschedule()
    {
        try {
            // $refreshschedule = YearlySchedule::all();
            $refreshschedule = DB::table('yearly_schedules')
            ->select('yearly_schedules.*', DB::raw('COUNT(DISTINCT machine_schedules.id) as machine_schedules_count'))
            ->leftJoin('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
            ->groupBy('yearly_schedules.id')
            ->get();

            // $refreshmachine = Machine::get('machine_abnormal');
            return response()->json([
                'refreshschedule' => $refreshschedule,
                'machine_schedules_count' => $refreshschedule->pluck('machine_schedules_count'),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
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

            $refreshschedulespecial = DB::table('yearly_schedules')
                ->select('monthly_schedules.*', 'yearly_schedules.id', 'monthly_schedules.id as getspecialid')
                ->join('monthly_schedules', 'yearly_schedules.id', '=', 'monthly_schedules.id_schedule_year')
                ->join('machine_schedules', 'monthly_schedules.id', '=', 'machine_schedules.special_id')
                ->groupBy('monthly_schedules.id')
                ->selectRaw('count(machine_schedules.special_id) as special_count')
                ->where('yearly_schedules.id', '=', $id)
                ->get();

            return response()->json([
                'refreshscheduledetail' => $refreshscheduledetail,
                'getmonthid' => $refreshscheduledetail->pluck('getmonthid'),
                'machine_count' => $refreshscheduledetail->pluck('machine_count'),
                'refreshschedulespecial' => $refreshschedulespecial,
                'getspecialid' => $refreshschedulespecial->pluck('getspecialid'),
                'special_count' => $refreshschedulespecial->pluck('special_count')
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
            $latestSchedules = DB::table('machines')
                ->select('machinerecords.*', 'machines.*', 'machinerecords.machine_id')
                ->join('machinerecords', 'machines.id', '=', 'machinerecords.machine_id')
                ->whereIn('machinerecords.id', function($query) {
                    $query->select(DB::raw('MAX(id)'))
                          ->from('machinerecords')
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
            $refreshmachine = Machine::where('machine_status', true)->get();

            // Ambil jadwal terbaru untuk setiap mesin
            $latestSchedules = DB::table('machines')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.machine_id')
            ->join('machinerecords', 'machines.id', '=', 'machinerecords.machine_id')
            ->whereIn('machinerecords.id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                        ->from('machinerecords')
                        ->groupBy('machine_id');
                    })
            ->get();

            $refreshschedule = DB::table('machine_schedules')
            ->select('yearly_schedules.name_schedule_year', 'yearly_schedules.schedule_year', 'machine_schedules.*')
            ->join('yearly_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
            ->where('yearly_schedules.id', '=', $id)
            ->whereIn('machine_schedules.id', function($query) {
                $query->select(DB::raw('MIN(id)'))
                      ->from('machine_schedules')
                      ->groupBy('machine_id');
            })
            ->get();

            return response()->json([
                'refreshschedule' => $refreshschedule,
                'refreshmachine' => $refreshmachine,
                'latestSchedules' => $latestSchedules
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
                ->select('yearly_schedules.id', 'machines.id', 'machinerecords.*')
                ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
                ->join('machines', 'machine_schedules.machine_id', '=', 'machines.id')
                ->join('machinerecords', 'machines.id', '=', 'machinerecords.machine_id')
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
            // dd($request)->all();
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
            $limit_schedule = $request->input('limit_schedule');

            // Validasi jumlah elemen pada semua array
            if (count($machine_key) !== count($schedule_times) || count($machine_key) !== count($preventive_cycles)) {
                return response()->json(['error' => 'Mismatch between machines, schedule times, and preventive cycles'], 400);
            }

            $StoreSchedule = new YearlySchedule();
            $StoreSchedule->name_schedule_year = $request->input('name_schedule');
            $StoreSchedule->schedule_year = $limit_schedule;
            $StoreSchedule->schedule_create = $request->input('schedule_create');
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

                    if ($new_schedule_start->year > $limit_schedule) {
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

    // fungsi dicadangkan karena masih terdapat bug
    // public function updatescheduleEXPERIMENTAL(Request $request, $id)
    // {
    //     try {
    //         // dd($request)->all();
    //         $request->validate([
    //             'name_schedule' => 'required',
    //             'limit_schedule' => 'required|integer',
    //             'schedule_time' => 'required|array',
    //             'machine_id' => 'required|array',
    //             'preventive_cycle' => 'required|array',
    //         ]);

    //         $machine_key = $request->input('machine_id');
    //         $schedule_times = $request->input('schedule_time');
    //         $preventive_cycles = $request->input('preventive_cycle');
    //         $limit_schedule = $request->input('limit_schedule');

    //         // Validasi jumlah elemen pada semua array
    //         if (count($machine_key) !== count($schedule_times) || count($machine_key) !== count($preventive_cycles)) {
    //             return response()->json(['error' => 'Mismatch between machines, schedule times, and preventive cycles'], 400);
    //         }

    //         $previous_machine_schedule = DB::table('yearly_schedules')
    //             ->select('yearly_schedules.id', 'machine_schedules.*', 'machine_schedules.id as machine_schedule')
    //             ->join('machine_schedules', 'yearly_schedules.id', '=', 'machine_schedules.yearly_id')
    //             ->where('yearly_schedules.id', '=', $id)
    //             ->get();

    //         // Ambil data ID MachineSchedule berdasarkan machine_id yang ada
    //         $previous_machine = $previous_machine_schedule->pluck('machine_id')->toArray();
    //         $deleted_machine = array_diff($machine_key, $previous_machine);

    //         // jika ada mesin yang dihapus dari schedule
    //         if ($deleted_machine) {
    //             // Hapus semua MachineSchedule yang tidak ada di request terbaru
    //             foreach ($deleted_machine as $delete_machine) {
    //                 MachineSchedule::where('machine_id', $delete_machine)->where('yearly_id', $id)->delete();
    //             }
    //         }

    //         $months_in_year = 12;

    //         foreach ($machine_key as $index => $key) {
    //             Log::info("Machine ID: " . $key);
    //             $ScheduleTimeRange = $schedule_times[$index];
    //             $ScheduleCycle = $preventive_cycles[$index];
    //             list($ScheduleStart, $ScheduleEnd) = explode(' - ', $ScheduleTimeRange);

    //             $result_in_year = $months_in_year / $ScheduleCycle;

    //             $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
    //             $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

    //             $PreviousMachineSchedule = MachineSchedule::where('machine_id', $key)->where('yearly_id', $id);
    //             $firstMachineSchedule = $PreviousMachineSchedule->first();

    //             if ($firstMachineSchedule) {
    //                 if ($firstMachineSchedule->preventive_cycle !== $ScheduleCycle) {
    //                     // Jika preventive cycle berbeda, update jadwal
    //                     $PreviousMachineSchedule->delete();

    //                     for ($i = 0; $i < $result_in_year; $i++) {
    //                         $new_schedule_start = $ScheduleStartCarbon->copy()->addMonths(($ScheduleCycle * $i));
    //                         $new_schedule_end = $ScheduleEndCarbon->copy()->addMonths(($ScheduleCycle * $i));

    //                         if ($new_schedule_start->year > $request->input('limit_schedule')) {
    //                             break; // Hentikan loop jika tahun mencapai limit_schedule
    //                         }

    //                         $UpdateMachineSchedule = new MachineSchedule();
    //                         $UpdateMachineSchedule->schedule_start = $new_schedule_start;
    //                         $UpdateMachineSchedule->schedule_end = $new_schedule_end;
    //                         $UpdateMachineSchedule->preventive_cycle = $ScheduleCycle;
    //                         $UpdateMachineSchedule->machine_id = $key;
    //                         $UpdateMachineSchedule->yearly_id = $id;
    //                         $UpdateMachineSchedule->save();
    //                     }
    //                 } else {
    //                     // Jika preventive cycle sama, lewati pembaruan
    //                     Log::info("Machine ID: $key already has the same preventive cycle. Skipping update.");
    //                 }
    //             } else {
    //                 // Jika tidak ada jadwal sebelumnya, buat jadwal baru
    //                 for ($i = 0; $i < $result_in_year; $i++) {
    //                     $new_schedule_start = $ScheduleStartCarbon->copy()->addMonths(($ScheduleCycle * $i));
    //                     $new_schedule_end = $ScheduleEndCarbon->copy()->addMonths(($ScheduleCycle * $i));

    //                     if ($new_schedule_start->year > $request->input('limit_schedule')) {
    //                         break; // Hentikan loop jika tahun mencapai limit_schedule
    //                     }

    //                     $UpdateMachineSchedule = new MachineSchedule();
    //                     $UpdateMachineSchedule->schedule_start = $new_schedule_start;
    //                     $UpdateMachineSchedule->schedule_end = $new_schedule_end;
    //                     $UpdateMachineSchedule->preventive_cycle = $ScheduleCycle;
    //                     $UpdateMachineSchedule->machine_id = $key;
    //                     $UpdateMachineSchedule->yearly_id = $id;
    //                     $UpdateMachineSchedule->save();
    //                 }
    //             }
    //         }

    //         // Update Year lySchedule
    //         $UpdateSchedule = YearlySchedule::find($id);
    //         $UpdateSchedule->name_schedule_year = $request->input('name_schedule');
    //         $UpdateSchedule->schedule_year = $limit_schedule;
    //         $UpdateSchedule->save();

    //         return response()->json(['success' => 'Schedule mesin berhasil di UPDATE!']);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['error' => 'Error updating data'], 500);
    //     }
    // }

    public function updateschedule(Request $request, $id)
    {
        try {
            // dd($request)->all();
            $request->validate([
                'name_schedule' => 'required',
                'limit_schedule' => 'required|integer',
                'combined_schedule' => 'required|array',
            ]);

            $name_schedule = $request->input('name_schedule');
            $limit_schedule = $request->input('limit_schedule');
            $combined_schedule = $request->input('combined_schedule');

            $months_in_year = 12;

            // Hapus semua MachineSchedule yang tidak ada di request terbaru
            foreach ($combined_schedule as $each_schedule) {
                list($machine_id, $schedule_cycles, $schedule_time_range) = explode(',', $each_schedule);
                list($ScheduleStart, $ScheduleEnd) = explode(' - ', $schedule_time_range);

                $result_in_year = $months_in_year / $schedule_cycles;

                $ScheduleStartCarbon = Carbon::parse($ScheduleStart);
                $ScheduleEndCarbon = Carbon::parse($ScheduleEnd);

                $PreviousMachineSchedule = MachineSchedule::where('machine_id', $machine_id)->where('yearly_id', $id);
                // dd($PreviousMachineSchedule);
                $firstMachineSchedule = $PreviousMachineSchedule->first();

                Log::info("Find Machine ID: " . $machine_id);
                Log::info("Find Schedule Cycles: " . $schedule_cycles);

                if ($firstMachineSchedule) {
                    Log::info("Last Schedule Cycles for Machine ID: " . $machine_id . " = " . $firstMachineSchedule->preventive_cycle);
                    if ($firstMachineSchedule->preventive_cycle == $schedule_cycles) {
                        Log::info("Skip schedule for Machine ID: " . $machine_id . " Because Have Same Preventive Cycle");
                        continue; // Skip update if preventive cycle is the same
                    } else {
                        // Jika preventive cycle berbeda, hapus jadwal lama
                        Log::info("Update schedule for Machine ID: " . $machine_id);
                        $PreviousMachineSchedule->delete();
                        $this->createNewScheduleData($ScheduleStartCarbon, $ScheduleEndCarbon, $result_in_year, $schedule_cycles, $limit_schedule, $machine_id, $id);
                    }
                } else if (!$firstMachineSchedule) {
                    $this->createNewScheduleData($ScheduleStartCarbon, $ScheduleEndCarbon, $result_in_year, $schedule_cycles, $limit_schedule, $machine_id, $id);
                    Log::info("Create new schedule for Machine ID: " . $machine_id);
                }
            }

            // Update Year lySchedule
            $UpdateSchedule = YearlySchedule::find($id);
            $UpdateSchedule->name_schedule_year = $name_schedule;
            $UpdateSchedule->schedule_year = $limit_schedule;
            $UpdateSchedule->save();

            return response()->json(['success' => 'Schedule mesin berhasil di UPDATE!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error updating data'], 500);
        }
    }

    private function createNewScheduleData($ScheduleStartCarbon, $ScheduleEndCarbon, $result_in_year, $schedule_cycles, $limit_schedule, $machine_id, $id)
    {
        // Buat jadwal baru
        for ($i = 0; $i < $result_in_year; $i++) {
            $new_schedule_start = $ScheduleStartCarbon->copy()->addMonths(($schedule_cycles * $i));
            $new_schedule_end = $ScheduleEndCarbon->copy()->addMonths(($schedule_cycles * $i));

            if ($new_schedule_start->year > $limit_schedule) {
                break; // Hentikan loop jika tahun mencapai limit_schedule
            }

            $UpdateMachineSchedule = new MachineSchedule();
            $UpdateMachineSchedule->schedule_start = $new_schedule_start;
            $UpdateMachineSchedule->schedule_end = $new_schedule_end;
            $UpdateMachineSchedule->preventive_cycle = $schedule_cycles;
            $UpdateMachineSchedule->machine_id = $machine_id;
            $UpdateMachineSchedule->yearly_id = $id;
            $UpdateMachineSchedule->save();
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
    // <<<==================================batas setujui schedule====================================>>>
    // <<<============================================================================================>>>

    public function indexscheduleaccept()
    {
        return view('dashboard.view_schedulemesin.tableacceptyear');
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

    public function registeraccept(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'accept_by' => 'required'
            ]);

            $accept_by = $request->input('accept_by');

            // Temukan jadwal berdasarkan ID
            $StoreSchedule = YearlySchedule::find($id);

            if (!$StoreSchedule) {
                return response()->json(['error' => 'Schedule not found !!!!'], 404);
            }

            // Cek izin pengguna
            $user = auth()->user(); // Ambil pengguna yang sedang login

            if ($user->hasPermissionTo('recognize_schedule')) {
                $StoreSchedule->schedule_recognize = $accept_by;
                $StoreSchedule->save();
            }

            if ($user->hasPermissionTo('agreed_schedule') && $user->hasPermissionTo('recognize_schedule')) {
                $StoreSchedule->schedule_recognize = $accept_by;
                $StoreSchedule->schedule_agreed = $accept_by;
                $StoreSchedule->save();
            }
            return response()->json(['success' => 'Data Schedule was successfully ACCEPTED']);
        } catch (\Exception $e) {
            // Log::info('User  permissions: ', $user->getAllPermissions()->toArray());
            Log::error('Update data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error sending data'], 500);
        }
    }

    // <<<============================================================================================>>>
    // <<<================================batas setujui schedule end==================================>>>
    // <<<============================================================================================>>>
}
