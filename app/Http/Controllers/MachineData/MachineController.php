<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachineController extends Controller
{
    // fungsi tambah mesin secara manual
    public function createmachine(Request $request)
    {
        try
        {
            $request->validate([
                'invent_number' => 'required',
                'machine_number'=> 'required',
                'machine_name' => 'required',
                'machine_brand',
                'machine_type',
                'machine_spec',
                'machine_made',
                'mfg_number' => 'required',
                'install_date',
            ]);

            Machine::create($request->all());
            return response()->json(['success' => 'Machine added successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Check again!!, there are fields that cannot be empty'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error machine failed to add!!!!'], 500);
        }
    }

    public function updatemachine(Request $request, $id)
    {
        try {
            $request->validate([
                'invent_number' => 'required',
                'machine_number'=> 'required',
                'machine_name' => 'required',
                'machine_brand',
                'machine_type',
                'machine_spec',
                'machine_made',
                'mfg_number' => 'required',
                'install_date',
                'id_property'

            ]);

            $machines = Machine::find($id);
            $machines->update($request->all());
            return response()->json(['success' => 'Machine updated successfully.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Machine failed to update!!!!'], 500);
        }
    }

    // fungsi hapus data mesin
    public function deletemachine($id) {
        try{
            $DeleteMachine = Machine::where('id', $id);
            $DeleteMachine->delete();
            return response()->json(['success' => 'Data mesin berhasil di HAPUS!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error delete data'], 500);
        }
    }
}
