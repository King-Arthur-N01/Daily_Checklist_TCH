<?php

namespace App\Http\Controllers;

use App\Machinerecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MachinerecordController extends Controller
{
    public function tablemachinerecord()
    {
        
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
    public function create()
    {
        //
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
