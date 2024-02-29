<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineresult;
use App\Componencheck;
use App\Machine;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface;

class MachineresultController extends Controller
{
    // public function indextablemachineresult()
    // {
    //     $machineresults = DB::table('machineresults')
    //         ->Join('machines', 'machinesresults.machine_code', '=', 'machines.id')
    //         ->where('machineresults.id','machines.machine_coderesult','machines.name_machine')
    //         ->get();

    //     $machineresults = Machineresult::with('machines')->orderBy('machine_coderesult', 'desc')->get();
    //     return view('dashboard.view_hasilmesin.tablemesinresult',['machineresults' => $machineresults])->with('machine_name');
    // }

    public function indextablemachineresult()
    {
        $machineresults = DB::table('machineresults')
        ->join('machines', 'machineresults.machine_coderesult', '=', 'machines.machine_code')
        ->join('componenchecks', 'machineresults.id_componencheck1', '=', 'componenchecks.id_componencheck')
        ->join('parameters', 'machineresults.id_parameter1', '=', 'parameters.id_parameter')
        ->join('metodechecks', 'machineresults.id_metodecheck1', '=', 'metodechecks.id_metodecheck')
        ->select('machineresults.*', 'machines.machine_name', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
        ->orderBy('machineresults.id', 'asc')
        // ->with(['machines', 'componenchecks', 'parameters', 'metodechecks'])
        ->get();

        // $machineresults = MachineResult::with(['machines', 'componenchecks', 'parameters', 'metodechecks'])->find($id);
        // $machineresults = MachineResult::with(['machines', 'componenchecks', 'parameters', 'metodechecks'])->orderBy('id','desc')->get();
        return view('dashboard.view_hasilmesin.tablemesinresult', ['machineresults' => $machineresults]);


        /*
        $machineresults = DB::table('machineresults')
            ->join('machines', 'machineresults.machine_coderesult', '=', 'machines.machine_name')
            ->leftJoin('componenchecks', function ($join) {
                $join->on('machineresults.id_componencheck1', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck2', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck3', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck4', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck5', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck6', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck7', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck8', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck9', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck10', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck11', '=', 'componenchecks.name_componencheck')
                    ->orOn('machineresults.id_componencheck12', '=', 'componenchecks.name_componencheck');
            })
            ->leftJoin('parameters', function ($join) {
                $join->on('machineresults.id_parameter1', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter2', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter3', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter4', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter5', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter6', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter7', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter8', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter9', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter10', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter11', '=', 'parameters.name_parameter')
                    ->orOn('machineresults.id_parameter12', '=', 'parameters.name_parameter');
            })
            ->leftJoin('metodechecks', function ($join) {
                $join->on('machineresults.id_metodecheck1', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck2', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck3', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck4', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck5', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck6', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck7', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck8', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck9', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck10', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck11', '=', 'metodechecks.name_metodecheck')
                    ->orOn('machineresults.id_metodecheck12', '=', 'metodechecks.name_metodecheck');
            })
            ->select('machineresults.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
            ->get();
        return view('dashboard.view_hasilmesin.tablemesinresult', ['machineresults' => $machineresults]);
        // return response()->json($results);
        */
    }

    public function indexregistermachineresult()
    {
        $machines = Machine::all('machine_name', 'machine_code');
        $componenchecks = Componencheck::all('name_componencheck', 'id_componencheck');
        $parameters = Parameter::all('name_parameter', 'id_parameter');
        $metodechecks = Metodecheck::all('name_metodecheck', 'id_metodecheck');

        return view('dashboard.view_hasilmesin.addmesinresult',[
            'machines' => $machines,
            'componenchecks' => $componenchecks,
            'parameters' => $parameters,
            'metodechecks' => $metodechecks
        ]);
    }

    public function indexeditmachineresult($id)
    {
        $machineresults=Machineresult::find($id);
        return view ('dashboard.view_hasilmesin.editmachine',['machineresults'=>$machineresults]);
    }

    public function registermachineresult(Request $request)
    {
        $request->validate([
            'machine_coderesult' => 'required|max:255',
            'id_componencheck1',
            'id_parameter1',
            'id_metodecheck1',
            'id_componencheck2',
            'id_parameter2',
            'id_metodecheck2',
            'id_componencheck3',
            'id_parameter3',
            'id_metodecheck3',
            'id_componencheck4',
            'id_parameter4',
            'id_metodecheck4',
            'id_componencheck5',
            'id_parameter5',
            'id_metodecheck5',
            'id_componencheck6',
            'id_parameter6',
            'id_metodecheck6',
            'id_componencheck7',
            'id_parameter7',
            'id_metodecheck7',
            'id_componencheck8',
            'id_parameter8',
            'id_metodecheck8',
            'id_componencheck9',
            'id_parameter9',
            'id_metodecheck9',
            'id_componencheck10',
            'id_parameter10',
            'id_metodecheck10',
            'id_componencheck11',
            'id_parameter11',
            'id_metodecheck11',
            'id_componencheck12',
            'id_parameter12',
            'id_metodecheck12'
        ]);
        Machineresult::create($request->all());
        return redirect()->route("managemachineresults")->withSuccess('Items added successfully.');
    }

    public function editmachineresult(Machineresult $machineresult)
    {
        //
    }

    public function destroy(Machineresult $machineresult)
    {
        //
    }
}
