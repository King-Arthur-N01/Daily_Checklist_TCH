<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function indextablemachine(){
        $machines=Machine::get();
        return view ('dashboard.tablemachine',['machines'=>$machines]);
    }

    public function indexregistermachine()
    {
        return view ('dashboard.addmachine');
    }

    public function indexupdatemachine()
    {

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
        $machine = Machine::create($request->all());
        //sembari update data nomor mesin
        $machine->machine_code = $currentvalue;
        $machine->save();

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
        $request->validate([
            'machine_code' => 'required',
            'invent_number' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        $Machines = Machine::find($id);
        $Machines->update($request->all());
        return redirect()->route("managemachine")->withSuccess('Items updated successfully.');
    }

    public function deletemachine($id)
    {
        Machine::where('id',$id)->delete();
        return redirect()->route("managemachine")->with('success', 'Items deleted successfully');
    }
}
