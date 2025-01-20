<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\WorkingHour;
use App\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WorkingHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexworkinghour()
    {
        return view('dashboard.view_working_hour.tableworkinghour');
    }

    public function refreshtableworkinghour()
    {
        try {
            // $refreshworkinghours = WorkingHour::get();
            $refreshworkinghours = DB::table('working_hours')
            ->select('working_hours.*', DB::raw('COUNT(DISTINCT machines.id) as machines_count'))
            ->join('machines', 'working_hours.id', '=', 'machines.standart_id')
            ->groupBy('working_hours.id')
            ->get();

            return response()->json([
                'refreshworkinghours' => $refreshworkinghours
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching machine data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function readmachinedata()
    {
        try {
            $machinedata = Machine::get();
            $workinghourdata = WorkingHour::get();

            return response()->json([
                'machinedata' => $machinedata,
                'workinghourdata' => $workinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching machine data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function findworkinghour($id)
    {
        try {
            $machinedata = Machine::get();
            $workinghourdata = WorkingHour::get();
            $selectedworkinghourdata = DB::table('working_hours')
            ->select('working_hours.*', 'machines.id', 'machines.id as machine_id')
            ->join('machines', 'working_hours.id', '=', 'machines.standart_id')
            ->where('working_hours.id', '=', $id)
            ->get();

            return response()->json([
                'machinedata' => $machinedata,
                'workinghourdata' => $workinghourdata,
                'selectedworkinghourdata' => $selectedworkinghourdata
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching machine data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function createworkinghour(Request $request)
    {
        try {
            $request->validate([
                'standart_name' => 'required',
                'priority' => 'required',
                'preventive_hour' => 'required',
                'man_power' => 'required',
            ]);

            $machine_array = $request->input('machine_input');

            $StoreWorkinghour = new WorkingHour();
            $StoreWorkinghour->standart_name = $request->standart_name;
            $StoreWorkinghour->priority = $request->priority;
            $StoreWorkinghour->preventive_hour = $request->preventive_hour;
            $StoreWorkinghour->man_power = $request->man_power;
            $StoreWorkinghour->save();

            $working_hour_id = $StoreWorkinghour->id;

            foreach ($machine_array as $machine) {
                $UpdateMachine = Machine::find($machine);
                $UpdateMachine->standart_id  = $working_hour_id ;
                $UpdateMachine->save();
            }

            return response()->json(['success' => 'Standarisasi jam pm mesin berhasil di BUAT!']);
        } catch (\Exception $e) {
            Log::error('Error adding property: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error machine property failed to add!!!!'], 500);
        }
    }

    public function updateworkinghour(Request $request, $id)
    {
        try {
            $request->validate([
                'standart_name' => 'required',
                'priority' => 'required',
                'preventive_hour' => 'required',
                'man_power' => 'required',
            ]);

            $standart_name = $request->input('standart_name');
            $priority = $request->input('priority');
            $preventive_hour = $request->input('preventive_hour');
            $man_power = $request->input('man_power');
            $machine_array = $request->input('machine_input', []);


            // $previous_working_hour = DB::table('working_hours')
            // ->select('working_hours.*', 'machines.*')
            // ->join('machines', 'working_hours.id', '=', 'machines.standart_id')
            // ->where('working_hours.id')
            // ->groupBy('standart_id')
            // ->get();

            // Ambil data working hour sebelumnya berdasarkan ID
            $previous_working_hour = DB::table('working_hours')
                ->select('working_hours.id', 'machines.id as machine_id')
                ->join('machines', 'working_hours.id', '=', 'machines.standart_id')
                ->where('working_hours.id', $id) // Tambahkan kondisi where yang benar
                ->get();

            // Ambil ID mesin yang sudah ada
            $previous_machine_ids = $previous_working_hour->pluck('machine_id')->toArray();

            // Tentukan ID yang perlu dihapus
            $delete_unused_id = array_diff($previous_machine_ids, $machine_array);

            foreach ($delete_unused_id as $delete_id) {
                $DeleteMachine = Machine::find($delete_id);
                if ($DeleteMachine) { // Pastikan objek ditemukan
                    $DeleteMachine->standart_id = null;
                    $DeleteMachine->save();
                }
            }

            $UpdateWorkinghour = WorkingHour::find($id);
            $UpdateWorkinghour->standart_name = $standart_name;
            $UpdateWorkinghour->priority = $priority;
            $UpdateWorkinghour->preventive_hour = $preventive_hour;
            $UpdateWorkinghour->man_power = $man_power;
            $UpdateWorkinghour->save();

            $working_hour_id = $UpdateWorkinghour->id;

            foreach ($machine_array as $machine) {
                $UpdateMachine = Machine::find($machine);
                $UpdateMachine->standart_id  = $working_hour_id ;
                $UpdateMachine->save();
            }

            return response()->json(['success' => 'Standarisasi jam pm mesin berhasil di UBAH!']);
        } catch (\Exception $e) {
            Log::error('Error adding property: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error machine property failed to add!!!!'], 500);
        }
    }

    public function viewworkinghour($id)
    {
        try {
            $getworkinghour = DB::table('working_hours')
            ->select('working_hours.*', 'machines.*')
            ->join('machines', 'working_hours.id', '=', 'machines.standart_id')
            ->where('working_hours.id', '=', $id)
            ->get();

            return response()->json(['getworkinghour' => $getworkinghour]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function deleteworkinghour($id)
    {
        try {
            $DeleteWorkingHour = WorkingHour::find($id);
            $DeleteWorkingHour->delete();
            return response()->json(['success' => 'Schedule mesin berhasil di HAPUS!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error delete data'], 500);
        }
    }
}
