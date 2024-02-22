<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function indextablemachine()
    {
        $machines=Machine::get();
        return view ('dashboard.view_mesin.tablemachine',['machines'=>$machines]);
    }

    public function indexregistermachine()
    {
        return view ('dashboard.view_mesin.addmachine');
    }

    public function indexupdatemachine($id)
    {
        $machines=Machine::find($id);
        return view ('dashboard.view_mesin.editmachine',['machines'=>$machines]);
    }

    public function registermachine(Request $request)
    {
        $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();

        if (isset($lastMachineCode)) {
            $currentvalue =  $lastMachineCode->machine_code + 1;
        } else {
            $currentvalue = 1;
        }
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
        $machines = Machine::create($request->all());
        //sembari update data nomor mesin
        $machines->machine_code = $currentvalue;
        $machines->save();

        return redirect()->route("managemachine")->withSuccess('Machine added successfully.');
    }

    // protected function createmachine(array $data)
    // {
    //     return Machine::create([
    //         'machine_code' => $data ['machine_code'],
    //         'machine_name' => $data ['machine_name'],
    //         'machine_brand'=> $data ['machine_brand'],???
    //         'machine_type' => $data ['machine_type'],
    //         'machine_spec' => $data ['machine_spec'],
    //         'mfg_number'   => $data ['mfg_number'],
    //         'invent_number'=> $data ['invent_number']
    //     ]);
    // }

    public function updatemachine(Request $request, $id)
    {
        // $currentvalue = Machine::orderBy('machine_code', 'desc')->first();
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
        $machines = Machine::find($id);
        $machines->update($request->all());
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        return redirect()->route("managemachine")->withSuccess('Machine updated successfully.');
    }

    public function deletemachine($id)
    {
        Machine::where('id',$id)->delete();
        return redirect()->route("managemachine")->with('success', 'Machine deleted successfully');
    }
}
