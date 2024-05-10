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
    public function __construct(){
        $this->middleware('permission:#namapermission#', ['only' => ['#namafunction#']]);
    }
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
        if ($joinmachine->isEmpty()) {
            // Return an error message or a default view
            return view('dashboard.view_blockpage.404', ['message' => 'No machine record found.']);
        }
        return view('dashboard.view_recordmesin.formrecordmesin', [
            'joinmachine' => $joinmachine,
            'machine_id' => $id,
            'timenow' => $timenow,
            'get_number'
        ]);
    }
    public function registermachinerecord(Request $request)
    {
        $getuserid = Auth()->user()->id;
        $getmachineid = ($request->input('id_machine2'));
        // Check the table to see if data has been filled in before
        $lastsubmissiontime = Machinerecord::where('id_machine2', $getmachineid)->value('record_time');

        if ($lastsubmissiontime){
            $lastsubmit = Carbon::parse($lastsubmissiontime);
            $currenttime = Carbon::now();
            if ($currenttime->diffInHours($lastsubmit) < 24 ){
                return redirect()->back()->with('error', 'You can submit the form again after 24 hours.');
            }
            else{
                $StoreRecords = new Machinerecord();
                $StoreRecords->machine_number2 = $request->input('machine_number2');
                $StoreRecords->shift = $request->input('shift');
                $StoreRecords->note = $request->input('note');
                $StoreRecords->id_machine2 = $request->input('id_machine2');
                $StoreRecords->record_time = $request->input('record_time');
                $StoreRecords->create_by = $getuserid;
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
        }elseif(!$lastsubmissiontime){
            $StoreRecords = new Machinerecord();
            $StoreRecords->machine_number2 = $request->input('machine_number2');
            $StoreRecords->shift = $request->input('shift');
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine2 = $request->input('id_machine2');
            $StoreRecords->record_time = $request->input('record_time');
            $StoreRecords->create_by = $getuserid;
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

    // <<<============================================================================================>>>
    // <<<==============================batas approval machine records 1==============================>>>
    // <<<============================================================================================>>>

    public function tablecorrection()
    {
        $getrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'users.name as getuser')
            ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->join('users', 'machinerecords.create_by', '=', 'users.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();

        return view('dashboard.view_recordmesin.tableapproval1', ['getrecords' => $getrecords]);
    }
    public function fetchdatarecord($id) // this code for ajax modal html
    {
        $machinedata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'metodechecks.id as checks_id')
            ->leftJoin('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->leftJoin('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $recordsdata = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'users.*', 'machinerecords.id as get_id', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users', 'machinerecords.create_by', '=' ,'users.id')
            ->where('machinerecords.id', '=', $id)
            ->get('mechinerecords.id');

        $combinedata = [];
        foreach ($machinedata as $getmachine){
            foreach ($recordsdata as $getrecords){
                if ($getmachine->checks_id == $getrecords->get_checks){
                    $combinedata[] = [
                        'machine_name' => $getmachine->machine_name,
                        'name_componencheck' => $getmachine->name_componencheck,
                        'name_parameter' => $getmachine->name_parameter,
                        'name_metodecheck' => $getmachine->name_metodecheck,
                        'operator_action' => $getrecords->operator_action,
                        'result' => $getrecords->result,
                    ];
                }
            }
        }
        return response()->json([
        'machinedata' => $machinedata,
        'recordsdata' => $recordsdata,
        'combinedata' => $combinedata
        ]);
    }
    public function registercorrection(Request $request, $id) // this code for ajax send request
    {
        $request->validate([
            'corrected_by' => 'required'
        ]);
        $machinerecord = Machinerecord::find($id);

        if (!$machinerecord) {
            return response()->json(['error' => 'Machine record not found'], 404);
        }
        else if ($machinerecord->corrected_by) {
            return response()->json(['error' => 'Data update failed. Record already corrected by someone else.'], 422);
        }
        $machinerecord->update(['corrected_by' => $request->input('corrected_by')]);

        return response()->json(['success' => 'Machine record updated successfully!']);
    }

    // <<<============================================================================================>>>
    // <<<============================batas approval machine records 1 end============================>>>
    // <<<============================================================================================>>>


    // <<<============================================================================================>>>
    // <<<==============================batas approval machine records 2==============================>>>
    // <<<============================================================================================>>>



    // <<<============================================================================================>>>
    // <<<============================batas approval machine records 2 end============================>>>
    // <<<============================================================================================>>>
    public function destroy(Machinerecord $machinerecord)
    {
        //
    }
}
