<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Machine;
use App\Machinerecord;
use App\Historyrecords;
use App\Metodecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MachinerecordController extends Controller
{
    public function tablemachinerecord()
    {
        $machines = Machine::all();
        return view('dashboard.view_recordmesin.tablerecordmesin', ['machines' => $machines]);
    }
    public function indexmachinerecord($id)
    {
        $machines = DB::table('machines')
            ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*','metodechecks.id as metodecheck_id')
            ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machines.id', '=', $id)
            ->get();

        return view('dashboard.view_recordmesin.formrecordmesin', [
            'machines' => $machines,
            'machine_id' => $id,
        ]);
    }

    public function registermachinerecord(Request $request)
    {
        $getuserid = Auth()->user()->id;

        $StoreRecords = new Machinerecord();
        $StoreRecords->machine_number = $request->input('machine_number');
        $StoreRecords->shift = $request->input('shift');
        $StoreRecords->note = $request->input('note');
        $StoreRecords->id_machine2 = $request->input('id_machine2');
        $StoreRecords->id_user = $getuserid;
        $StoreRecords->save();

        // Get the ID of the newly created record
        $getrecordid = Machinerecord::latest('id')->first()->id;

        $metodecheck_id = $request->input('metodecheck_id', []);
        foreach($metodecheck_id as $key => $test)
        {
            $StoreHistory = new Historyrecords();
            $StoreHistory->id_metodecheck = $test;
            $StoreHistory->operator_action = $request->input('operator_action')[$key];
            $StoreHistory->result = $request->input('result')[$key];
            $StoreHistory->id_machinerecord = $getrecordid;
            $StoreHistory->save();
        }
        return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
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
