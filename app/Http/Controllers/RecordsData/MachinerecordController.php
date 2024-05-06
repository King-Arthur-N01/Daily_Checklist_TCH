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
        $getusername = Auth()->user()->name;
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
                $StoreRecords->create_by = $getusername;
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
        }elseif(!$lastsubmissiontime){
            $StoreRecords = new Machinerecord();
            $StoreRecords->machine_number2 = $request->input('machine_number2');
            $StoreRecords->shift = $request->input('shift');
            $StoreRecords->note = $request->input('note');
            $StoreRecords->id_machine2 = $request->input('id_machine2');
            $StoreRecords->record_time = $request->input('record_time');
            $StoreRecords->create_by = $getusername;
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

    // <<<============================================================================================>>>
    // <<<==============================batas approval machine records 1==============================>>>
    // <<<============================================================================================>>>

    public function approve1machinerecord()
    {
        $joindata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'users.name as getuser')
            ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->join('users', 'machinerecords.id_user', '=', 'users.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();

        return view('dashboard.view_recordmesin.tableapproval1', ['joindata' => $joindata]);
    }
    public function fetchdatarecord1($id)
    {
        $detailrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'metodechecks.id as checks_id')
            ->leftJoin('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->leftJoin('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $historyrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'users.*', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users', 'machinerecords.id_user', '=' ,'users.id')
            ->where('machinerecords.id', '=', $id)
            ->get('mechinerecords.id');

        $combinedata = [];
        foreach ($detailrecords as $detail){
            foreach ($historyrecords as $history){
                if ($detail->checks_id == $history->get_checks){
                    $combinedata[] = [
                        'machine_name' => $detail->machine_name,
                        'name_componencheck' => $detail->name_componencheck,
                        'name_parameter' => $detail->name_parameter,
                        'name_metodecheck' => $detail->name_metodecheck,
                        'operator_action' => $history->operator_action,
                        'result' => $history->result,
                    ];
                }
            }
        }
        return response()->json([
        'detailrecords' => $detailrecords,
        'historyrecords' => $historyrecords,
        'combinedata' => $combinedata
        ]);
    }
    public function registerapproval1(Request $request, $id)
    {
        $request->validate([
            'corrected_by' => 'required'
        ]);
        // dd($request);
        $machineRecord = Machinerecord::find($id);
        $machineRecord->update(['corrected_by' => $request->input('corrected_by')]);
        return response()->json(['success' => 'Machine record updated successfully!']);
    }

    // <<<============================================================================================>>>
    // <<<============================batas approval machine records 1 end============================>>>
    // <<<============================================================================================>>>
    public function destroy(Machinerecord $machinerecord)
    {
        //
    }
}
