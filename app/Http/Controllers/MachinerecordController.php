<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
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
        // $machinerecords = Machinerecord::with('users')->find($id);
        $machines = Machine::all();
        return view('dashboard.view_recordmesin.tablerecordmesin',['machines'=>$machines]);
    }
    public function indexmachinerecord($id)
    {
        $machines = DB::table('machines')
        ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->where('machines.id', '=', $id)
        ->get();

        // $machinerecords = DB::table('machinerecords')
        // ->select('machines.*', 'users.*')
        // ->join('machines', 'machinerecords.id_machinerecord', '=', 'machines.id')
        // ->join('users', 'machinerecords.id_user', '=', 'users.id')
        // ->where('machines.id', '=', $id)
        // ->where('users.id', '=', 2)
        // ->get();

        // $machinerecords = Machinerecord::with('machines')->find($id);
        // $machines = Machine::find($id);
        $machinerecords = Machinerecord::all();
    return view('dashboard.view_recordmesin.formrecordmesin',['machines'=>$machines ,'machinerecords'=>$machinerecords]);
    }
    public function registermachinerecord(Request $request)
    {
        $id = Auth::id();
        $request->validate([
            'action_check' => 'required',
            'action_cleaning' => 'required',
            'action_adjust' => 'required',
            'action_replace' => 'required',
            'shift' ,
            'result',
            'note'
        ]);
        // simpan data
        $machinesrecords = Machinerecord::create($request->all());
        // sembari update data nomor mesin
        $machinesrecords->id_user = $id;
        $machinesrecords->save();
        // Machinerecord::create($request->all());
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
