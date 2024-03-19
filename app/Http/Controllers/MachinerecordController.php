<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Machine;
use App\Machinerecord;
use App\Metodecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MachinerecordController extends Controller
{
    public function tablemachinerecord()
    {
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
        $machinerecords = Machinerecord::all();
    return view('dashboard.view_recordmesin.formrecordmesin',[
        'machines'=>$machines,
        'machinerecords'=>$machinerecords,
    ]);
    }
    public function registermachinerecord(Request $request)
    {
        $operatoraction = $request->input('operator_action', []);
        $result = $request->input('result', []);
        $get_machineid = Machine::select('id')->get();
        $getuserid = Auth()->user()->id;

        $storeInfo = new Machinerecord();
        $storeInfo->operator_action = implode(',', $operatoraction);
        $storeInfo->result = implode(',', $result);
        $storeInfo->note= $request->input('note');
        // $storeInfo->note= $request->input('id_machinerecord');
        $storeInfo -> id_user = $getuserid;
        $storeInfo -> id_machinerecord = $get_machineid;
        $storeInfo->save();
        dd($storeInfo);
        return redirect()->route("indexmachinerecord")->withSuccess('Machine added successfully.');
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
