<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
    public function formmachinerecord($id)
    {
        $timenow = Carbon::now();

        $joinmachine = DB::table('machines')
            ->select(
                'machines.*','componenchecks.*','parameters.*','metodechecks.*',
                /*alias for formrecordmesin*/
                'machines.machine_number as get_number','metodechecks.id as metodecheck_id')
            ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machines.id', '=', $id)
            ->get();

        return view('dashboard.view_recordmesin.formrecordmesin', [
            'joinmachine' => $joinmachine,
            'machine_id' => $id,
            'timenow' => $timenow,
            'get_number'
        ]);
    }
    // public function filter(Request $request)
    // {
    //     $query = Machinerecord::query();

    //     if ($request->has('category')) {
    //         $query->where('category', $request->category);
    //     }

    //     // Add more filters as needed...

    //     $items = $query->get();
    //     return response()->json($items);
    // }
    public function registermachinerecord(Request $request)
    {
        $getuserid = Auth()->user()->id;
        // $getmachineid = Machine::where('id', $request->input('machine_number2'))->value('machine_number');
        $lastsubmission = Machinerecord::where('id_user', $getuserid)->latest()->first();

        if ($lastsubmission) {
            $currenttime = Carbon::now();
            $lastsubmit = Carbon::parse($lastsubmission->create_at);

            // Check if 24 hours have passed since the last submission
            if ($currenttime->diffInHours($lastsubmit) < 24) {
                return redirect()->back()->with('error', 'You can submit the form again after 24 hours.');
            }
        }else {
            $StoreRecords = new Machinerecord();
            $StoreRecords->machine_number2 = $request->input('machine_number2');
            $StoreRecords->shift = $request->input('shift');
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine2 = $request->input('id_machine2');
            $StoreRecords->id_user = $getuserid;
            $StoreRecords->save();

            // Get the ID of the newly created record
            $getrecordid = Machinerecord::latest('id')->first()->id;

            $metodecheck_id = $request->input('metodecheck_id', []);
            foreach ($metodecheck_id as $key => $test) {
                $StoreHistory = new Historyrecords();
                $StoreHistory->id_metodecheck = $test;
                $StoreHistory->operator_action = $request->input('operator_action')[$key];
                $StoreHistory->result = $request->input('result')[$key];
                $StoreHistory->id_machinerecord = $getrecordid;
                $StoreHistory->save();
            }
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
