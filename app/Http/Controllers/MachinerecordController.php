<?php

namespace App\Http\Controllers;

use App\Machine;
use App\Machinerecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MachinerecordController extends Controller
{
    public function tablemachinerecord()
    {
        // $machinerecords = DB::table('machinerecords')
        // ->join('machines', 'machinerecords.id_machinerecord', '=', 'machines.id')
        // ->join('users', 'machinerecords.id_user', '=', 'users.id')
        // ->select('machines.*', 'users.*')
        // ->orderBy('machinerecords.id', 'asc')
        // ->get();

        $machines = Machine::all();
        return view('dashboard.view_recordmesin.tablerecordmesin',['machines'=>$machines]);
    }
    public function indexmachinerecord()
    {
        $machines = DB::table('machines')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->orderBy('machines.id', 'asc')
        ->get();
        return view('dashboard.view_recordmesin.formrecordmesin',['machines'=>$machines]);
    }
    public function createrecord(Request $request)
    {
        $request->validate([
            'action_check' => 'required',
            'action_cleaning' => 'required',
            'action_adjust' => 'required',
            'action_replace' => 'required',
            'result',
            'department',
            'note'
        ]);
        Machinerecord::create($request->all());
        return redirect()->route("managemachine")->withSuccess('Machine updated successfully.');
    }
    public function edit(Machinerecord $machinerecord)
    {
        //
    }
    public function destroy(Machinerecord $machinerecord)
    {
        //
    }
}
