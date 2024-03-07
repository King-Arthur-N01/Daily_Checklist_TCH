<?php

namespace App\Http\Controllers;

use App\Machinerecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MachinerecordController extends Controller
{
    public function tablemachinerecord()
    {
        $machinerecords = DB::table('machinerecords')
        ->join('machines', 'machinerecords.id_machinerecord', '=', 'machines.id')
        ->join('users', 'machinerecords.id_user', '=', 'users.id')
        ->select('machines.*', 'users.*')
        ->orderBy('machinerecords.id', 'asc')
        ->get();
        return view('dashboard.view_recordmesin.tablerecordmesin',['machinerecords'=>$machinerecords]);
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
        $currentYear = now()->year;
        $currentvalue = Machinerecord::where('year', $currentYear)->orderBy('id_machinerecord', 'desc')->first();
        $request->validate([
            'action_check',
            'action_cleaning',
            'action_adjust',
            'action_replace'
        ]);
        //simpan data
        $record = Machinerecord::create($request->all());
        //sembari update data nomor mesin
        $record->id_machinerecord = $currentvalue;
        $record->save();
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
