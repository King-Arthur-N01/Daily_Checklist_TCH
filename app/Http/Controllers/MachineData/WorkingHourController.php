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
            $refreshworkinghours = WorkingHour::get();
            return response()->json([
                'refreshworkinghours' => $refreshworkinghours
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function readmachinedata()
    {
        try {
            $refreshmachine = Machine::all();

            return response()->json([
                'refreshmachine' => $refreshmachine
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching machine data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    public function findworkinghour($id)
    {
        try {
            $refreshmachine = Machine::all();
            $refreshworkinghours = WorkingHour::find($id);

            return response()->json([
                'refreshmachine' => $refreshmachine,
                'refreshworkinghours' => $refreshworkinghours
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
            $machine_json = json_encode($machine_array);

            $StoreWorkinghour = new WorkingHour();
            $StoreWorkinghour->standart_name = $request->standart_name;
            $StoreWorkinghour->priority = $request->priority;
            $StoreWorkinghour->machine_total = $machine_json;
            $StoreWorkinghour->preventive_hour = $request->preventive_hour;
            $StoreWorkinghour->man_power = $request->man_power;
            $StoreWorkinghour->save();

            $working_hour_id = $StoreWorkinghour->id;

            foreach ($machine_array as $machine) {
                $UpdateMachine = Machine::find($machine);
                $UpdateMachine->id_standart  = $working_hour_id ;
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


            $working_hour = WorkingHour::find($id);
            $previous_machine_id = json_decode($working_hour->machine_total);

            // Tentukan ID yang perlu dihapus
            $delete_unused_id = array_diff($previous_machine_id, $machine_array);

            // Hapus semua value MachineSchedule->monthy_id yang tidak memiliki hubungan dengan monthly_schedules di request terbaru
            foreach ($delete_unused_id as $delete_id) {
                $DeleteMachine = Machine::find($delete_id);
                $DeleteMachine->id_standart = null;
                $DeleteMachine->save();
            }

            $UpdateWorkinghour = WorkingHour::find($id);
            $UpdateWorkinghour->standart_name = $standart_name;
            $UpdateWorkinghour->priority = $priority;
            $UpdateWorkinghour->preventive_hour = $preventive_hour;
            $UpdateWorkinghour->man_power = $man_power;
            $UpdateWorkinghour->machine_total = json_encode($machine_array);
            $UpdateWorkinghour->save();

            $working_hour_id = $UpdateWorkinghour->id;

            foreach ($machine_array as $machine) {
                $UpdateMachine = Machine::find($machine);
                $UpdateMachine->id_standart  = $working_hour_id ;
                $UpdateMachine->save();
            }

            return response()->json(['success' => 'Standarisasi jam pm mesin berhasil di BUAT!']);
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
            ->join('machines', 'working_hours.id', '=', 'machines.id_standart')
            ->where('working_hours.id', '=', $id)
            ->get();

            return response()->json(['getworkinghour' => $getworkinghour]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkingHour  $workingHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkingHour $workingHour)
    {
        //
    }
}
