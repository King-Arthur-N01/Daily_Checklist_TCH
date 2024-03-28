<?php

namespace App\Http\Controllers;

use App\Historyrecords;
use App\Machinerecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistoryrecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indextablehistory()
    {
        $joinrecords = DB::table('machinerecords')
        ->select('machinerecords.*','machines.*','machinerecords.id as records_id')
        ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
        ->orderBy('machinerecords.id', 'asc')
        ->get();

        return view ('dashboard.view_history.tablehistory', ['joinrecords' => $joinrecords]);
    }

    public function viewdetails($id)
    {

        $historyrecords = DB::table('machinerecords')
        ->select('machinerecords.*', 'historyrecords.*', 'machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*'
        ,'machinerecords.machine_number as record_number', 'machinerecords.note as record_note')
        ->join('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
        ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->where('machinerecords.id', '=', $id)
        ->get();

        return view ('dashboard.view_history.detailspreventive',[
            'historyrecords' => $historyrecords
        ]);
    }

    public function insertoperatoraction(Request $request)
    {
        $operatoraction = $request->input('operator_action', []);
        $result = $request->input('result', []);

        $storeData = new Historyrecords();
        $storeData->operator_action = implode(',', $operatoraction);
        $storeData->result = implode(',', $result);
        $storeData->save();
        return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Historyrecords $historyrecords)
    {
        //
    }

    public function edit(Historyrecords $historyrecords)
    {
        //
    }

    public function update(Request $request, Historyrecords $historyrecords)
    {
        //
    }

    public function destroy(Historyrecords $historyrecords)
    {
        //
    }
}
