<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function indexatablemachine()
    {
        return view ('');
    }

    public function indexregistermachine()
    {
        return view ('');
    }
    public function createmachine(Request $request)
    {
        $request->validate([
            'machine_code' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand' => 'required',
            'machine_type',
            'machine_spec',
            'mfg_number' => 'required',
            'invent_number' => 'required'
        ]);
        Machine::create($request->all());
        return redirect()->route("#")->withSuccess('Machine added successfully.');
    }

    // protected function createmachine(array $data)
    // {
    //     return Machine::create([
    //         'machine_code' => $data ['machine_code'],
    //         'machine_name' => $data ['machine_name'],
    //         'machine_brand'=> $data ['machine_brand'],
    //         'machine_type' => $data ['machine_type'],
    //         'machine_spec' => $data ['machine_spec'],
    //         'mfg_number'   => $data ['mfg_number'],
    //         'invent_number'=> $data ['invent_number']
    //     ]);
    // }

    public function store(Request $request)
    {

    }

    public function show(Machine $machine)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'machine_code' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand' => 'required',
            'machine_type',
            'machine_spec',
            'mfg_number' => 'required',
            'invent_number' => 'required'
        ]);
        $Machines = Machine::find($id);
        $Machines->update($request->all());
        return redirect()->route("#")->withSuccess('Items updated successfully.');
    }

    public function update(Request $request, Machine $machine)
    {
        //
    }

    public function destroy(Machine $machine)
    {
        //
    }
}
