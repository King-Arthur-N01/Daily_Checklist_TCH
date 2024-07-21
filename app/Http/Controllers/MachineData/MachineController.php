<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function indexmachine()
    {
        $machines=Machine::get();
        return view ('dashboard.view_mesin.tablemachine',['machines'=>$machines]);
    }

    public function notuseregistermachine()
    {
        return view ('dashboard.view_mesin.addmachine');
    }

    public function updatemachine($id)
    {
        $machines=Machine::find($id);
        return view ('dashboard.view_mesin.editmachine',['machines'=>$machines]);
    }

    public function pushregistermachine(Request $request)
    {
        // $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();
        // if (isset($lastMachineCode)) {
        //     $currentvalue =  $lastMachineCode->machine_code + 1;
        // } else {
        //     $currentvalue = 1;
        // }
        $request->validate([
            'invent_number' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        //simpan data
        // $machines = Machine::create($request->all());
        //sembari update data nomor mesin
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        Machine::create($request->all());
        return redirect()->route("managemachine")->withSuccess('Machine added successfully.');
    }

    public function pushupdatemachine(Request $request, $id)
    {
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        $machines = Machine::find($id);
        $machines->update($request->all());
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        return redirect()->route("managemachine")->withSuccess('Machine updated successfully.');
    }

    // fungsi tambah mesin secara manual
    public function registermachine(Request $request)
    {
        // dd($request);
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
            'machine_number'=> 'required',
        ]);
        try {
            Machine::create($request->all());
            return response()->json(['success' => 'Machine added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Machine failed to add!!!!']);
        }
    }

    // fungsi hapus data mesin
    public function deletemachine($id) {
        $deletemachine = Machine::where('id', $id)->delete();

        if ($deletemachine > 0) {
            return response()->json(['success' => 'Data mesin berhasil dihapus!']);
        } else {
            return response()->json(['error' => 'Data mesin gagal dihapus.'], 422);
        }
    }
}
