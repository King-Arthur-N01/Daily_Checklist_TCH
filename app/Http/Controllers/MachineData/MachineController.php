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
                'machine_brand' => 'nullable',
                'machine_type' => 'nullable',
                'machine_spec' => 'nullable',
                'machine_power' => 'nullable',
                'machine_made' => 'nullable',
                'machine_info' => 'nullable',
                'mfg_number' => 'nullable',
                'install_date' => 'nullable',
                'production_date' => 'nullable'
            ]);

            $invent_number = $request->input('invent_number');

            $isExists = Machine::where('invent_number', $invent_number)
                ->exists();

            if ($isExists) {
                return response()->json(['error' => 'Mesin dengan nomor inventaris ini sudah ada!'], 422);
            }

            Machine::create($request->all());
            return response()->json(['success' => 'Mesin berhasil ditambahkan']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Periksa lagi!, ada kolom yang tidak boleh kosong'], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Kesalahan mesin gagal ditambahkan!!!!'], 500);
        }
    }

    public function updatemachine(Request $request, $id)
    {
        try {
            // dd($request->all());
            $request->validate([
                'invent_number' => 'required',
                'machine_number'=> 'nullable',
                'machine_name' => 'required',
                'machine_brand' => 'nullable',
                'machine_type' => 'nullable',
                'machine_spec' => 'nullable',
                'machine_power' => 'nullable',
                'machine_made' => 'nullable',
                'machine_status' => 'required',
                'machine_info' => 'nullable',
                'mfg_number' => 'nullable',
                'install_date' => 'nullable',
                'production_date' => 'nullable',
                'property_id' => 'nullable',
                'standart_id' => 'nullable',
            ]);

            $invent_number = $request->input('invent_number');

            $isExists = Machine::where('invent_number', $invent_number)
                ->where('id', '!=', $id)
                ->exists();

            if ($isExists) {
                return response()->json(['error' => 'Mesin dengan nomor inventaris ini sudah ada!'], 422);
            }

            $machine = Machine::findOrFail($id);
            $machine->update($request->all());

            return response()->json(['success' => 'Mesin berhasil diupdate']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Kesalahan mesin gagal diperbaharui!!!!'], 500);
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
