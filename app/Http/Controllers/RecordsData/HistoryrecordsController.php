<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use App\Historyrecords;
use App\Machinerecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistoryrecordsController extends Controller
{
    public function indextablehistory()
    {
        $joinrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id')
            ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();

        return view('dashboard.view_history.tablehistory', ['joinrecords' => $joinrecords]);
    }

    public function viewdetails($id)
    {
        $detailrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'metodechecks.id as checks_id')
            ->leftJoin('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->leftJoin('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get();

        $historyrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'machinerecords.machine_number as records_number', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->where('machinerecords.id', '=', $id)
            ->get();

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
        // dd($detailrecords);
        // dd($historyrecords);
        return view('dashboard.view_history.detailspreventive', [
            'detailrecords' => $detailrecords,
            'historyrecords' => $historyrecords,
            'combinedata' => $combinedata,
        ]);
    }

    public function insertoperatoraction(Request $request)
    {
        // $operatoraction = $request->input('operator_action', []);
        // $result = $request->input('result', []);

        // $storeData = new Historyrecords();
        // $storeData->operator_action = implode(',', $operatoraction);
        // $storeData->result = implode(',', $result);
        // $storeData->save();
        // return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
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
