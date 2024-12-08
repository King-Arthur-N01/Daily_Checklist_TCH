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
            // dd($request);
            $request->validate([
                'invent_number' => 'required',
                'machine_number'=> 'required',
                'machine_name' => 'required',
                'machine_brand' => 'nullable',
                'machine_type' => 'nullable',
                'machine_spec' => 'nullable',
                'machine_made' => 'nullable',
                'mfg_number' => 'required',
                'install_date' => 'nullable'
            ]);

            $machine_number = $request->input('machine_number');

            $isExists = Machine::where('machine_number', $machine_number)
                ->where('machine_status', true)
                ->exists();

            if ($isExists) {
                return response()->json(['error' => 'Machine with this number is already exists!!!.'], 422);
            }

            Machine::create($request->all());
            return response()->json(['success' => 'Machine added successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Check again!!, there are fields that cannot be empty'], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
                'machine_status' => 'required',
                'mfg_number' => 'required',
                'install_date',
                'id_property'
            ]);

            $machine_number = $request->input('machine_number');
            $machine_status = $request->input('machine_status');

            $isExists = Machine::where('machine_number', $machine_number)
                ->where('machine_status', true)
                ->where('id', '!=', $id)
                ->exists();

            if ($isExists && $machine_status == true) {
                return response()->json(['error' => 'Machine with this number is already active.'], 422);
            }

            $machine = Machine::findOrFail($id);
            $machine->update($request->all());

            return response()->json(['success' => 'Machine updated successfully.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error machine failed to update!!!!'], 500);
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
