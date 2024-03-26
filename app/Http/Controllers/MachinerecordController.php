<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Machine;
use App\Machinerecord;
use App\Historyrecords;
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
        // $machines = Machine::find($id);
        $machines = DB::table('machines')
            ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
            ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machines.id', '=', $id)
            ->get();

        // $machinerecords = Machinerecord::where('id_machinerecord', $id)->first();

        return view('dashboard.view_recordmesin.formrecordmesin', [
            'machines' => $machines,
            'machine_id' => $id,
        ]);
    }
    // public function registermachinerecord(Request $request)
    // {
    //     $getuserid = Auth()->user()->id;

    //     $storeInfo = new $request->only(['shift','note','machine_number','id_machine','id_user']);
    //     $storeInfo = Machinerecord::create([
    //         'shift' => $request->input('shift'),
    //         'note' => $request->input('note'),
    //         'machine_number' => $request->input('machine_number'),
    //         'id_machine' => $request->input('id_machine'),
    //         'id_user' => $getuserid
    //     ]);
    //     $storeInfo->save();

    //     $getrecordid =  Machinerecord::latest('id')->first();

    //     $storeData = new $request->only(['id_metodecheck','id_machinerecord','operator_action','result']);
    //     $storeData = Historyrecords::create([
    //         // 'id_metodecheck' => $request->input('id_metodecheck'),
    //         'operator_action' => $request->input('operator_action'),
    //         'result' => $request->input('result'),
    //         'id_machinerecord' => $getrecordid
    //     ]);
    //     $storeData->save();
    //     return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
    // }

    public function registermachinerecord(Request $request)
    {
        $operator_action = $request->input('operator_action', []);
        $result = $request->input('result', []);
        // $getmachineid = Machine::where('id', $request->id)->first();
        $getuserid = Auth()->user()->id;
        // dd($request);

        // Store information in the first table
        Machinerecord::create([
            'machine_number' => $request->input('machine_number'),
            // 'shift' => $request->input('shift'),
            'note' => $request->input('note'),
            'id_machine2' => $request->input('id_machine2'),
            // 'id_machine2' => $getmachineid,
            'id_user' => $getuserid
        ]);

        // Get the ID of the newly created record
        $getrecordid = Machinerecord::latest('id')->first()->id;

        // Store additional data in the second table
        Historyrecords::create([
            'id_metodecheck' => $request->id_metodecheck,
            'operator_action' => implode(',', $operator_action),
            'result' => implode(',', $result),
            'id_machinerecord' => $getrecordid
        ]);

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
