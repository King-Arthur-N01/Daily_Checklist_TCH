<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machinerecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function indextablehistory()
    {
        $machinerecords = Machinerecord::all('id');
        $joinrecords = DB::table('machinerecords')
        ->select('machinerecords.*', 'machines.*')
        ->join('machines', 'machinerecords.id_machinerecord', '=', 'machines.id')
        ->orderBy('machinerecords.id', 'asc')
        ->get();
        return view('dashboard.view_history.tablehistory', [
            'joinrecords' => $joinrecords,
            'machinerecords' => $machinerecords
        ]);
    }
    public function viewdetails($id)
    {
        $machinerecords = Machinerecord::find($id);

        $historyrecords = DB::table('machinerecords')
        ->select('machinerecords.*', 'machines.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
        ->join('machines', 'machinerecords.id_machinerecord', '=', 'machines.id')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->where('machinerecords.id', '=', $machinerecords->id)
        ->get();

        return view ('dashboard.view_history.detailspreventive',[
            'historyrecords' => $historyrecords,
            'machinerecords' => $machinerecords
        ]);
    }
}
