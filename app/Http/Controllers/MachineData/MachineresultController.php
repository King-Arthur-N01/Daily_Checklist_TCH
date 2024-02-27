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
            ->join('machines', 'machineresults.machine_coderesult', '=', 'machines.id')
            ->select('machineresults.*', 'machines.machine_name')
            ->orderBy('machineresults.machine_coderesult', 'desc')
            ->get();
        return view('dashboard.view_hasilmesin.tablemesinresult', ['machineresults' => $machineresults]);
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
