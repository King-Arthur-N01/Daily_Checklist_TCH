<?php

namespace App\Http\Controllers;

use App\MasterMachine;
use App\Machineresult;
use Illuminate\Http\Request;

class MasterMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexregisterpreventivemachine()
    {
        $mastermachines = MasterMachine::all('name_machinedata', 'id');
        $machineresults = Machineresult::all('name_machinecode', 'id');

        return view('dashboard.view_hasilmesin.addmesinresult', [
            'mastermachines' => $mastermachines,
            'machineresults' => $machineresults
        ]);
    }
    public function registerpreventivemachine(Request $request)
    {
        $request->validate([
            'name_metodecheck' => 'required|max:255',
        ]);
        $preventivemachine = MasterMachine::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterMachine  $masterMachine
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterMachine $masterMachine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterMachine  $masterMachine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterMachine $masterMachine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterMachine  $masterMachine
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterMachine $masterMachine)
    {
        //
    }
}
