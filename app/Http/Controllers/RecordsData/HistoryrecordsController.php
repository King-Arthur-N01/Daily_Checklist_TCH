<?php

namespace App\Http\Controllers\RecordsData;

use App\Http\Controllers\Controller;
use App\Historyrecords;
use App\Machinerecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistoryrecordsController extends Controller
{
    // fungsi untuk melihat table riwayat dan status preventive mesin
    public function indexhistory()
    {
        return view('dashboard.view_history.tablehistory');
    }

    public function refreshtablehistory()
    {
        $joinrecords = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machinerecords.id as records_id', 'machinerecords.created_at as getcreatedate', 'machinerecords.create_by as getusercreate', 'machinerecords.correct_by as getcorrect', 'machinerecords.approve_by as getapprove')
            ->join('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->orderBy('machinerecords.id', 'asc')
            ->get();
        return response()->json([
            'joinrecords' => $joinrecords
        ]);
    }

    // fungsi tampilan formulir untuk melihat riwayat dan status preventive mesin (record mesin)
    public function viewdetails($id)
    {
        $machinedata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'machineproperties.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
            ->leftJoin('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->leftJoin('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get();

        $recordsdata = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'users_correct.name as correct_by_name', 'users_approve.name as approve_by_name')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users as users_correct', 'machinerecords.correct_by', '=' ,'users_correct.id')
            ->leftJoin('users as users_approve', 'machinerecords.approve_by', '=' ,'users_approve.id')
            ->where('machinerecords.id', '=', $id)
            ->get();

        $usernames = [];
        $combineuser = $recordsdata->first()->create_by;
        
        $splituser = explode(',', $combineuser);
        foreach ($splituser as $eachuserid){
            $usernames[] = DB::table('users')->select('name')->where('id', $eachuserid)->first()->name;
        }

        $combinedata = [];
        foreach ($machinedata as $detail){
            $combinedata[] = [
                'machine_name' => $detail->machine_name,
                'name_componencheck' => $detail->name_componencheck,
                'name_parameter' => $detail->name_parameter,
                'name_metodecheck' => $detail->name_metodecheck,
            ];
        }
        $combineresult[] = [
            'operator_action' => $recordsdata->first()->operator_action,
            'result' => $recordsdata->first()->result
        ];

        return view('dashboard.view_history.detailspreventive', [
            'machinedata' => $machinedata,
            'recordsdata' => $recordsdata,
            'combinedata' => $combinedata,
            'combineresult' => $combineresult,
            'usernames' => $usernames
        ]);
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
