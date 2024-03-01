<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function indextablemachineresult(){

        $machine = DB::table('machines')
        ->join('componenchecks', 'machines.machine_code', '=', 'componenchecks.machine_code_componencheck')
        ->join('parameters', 'componenchecks.id_componencheck', '=', 'parameters.componencheck_parameter')
        ->join('metodechecks', 'parameters.id_parameter', '=', 'metodechecks.parameter_metodecheck')
        ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->orderBy('machines.id', 'asc')
        ->get();

        /*
        $machineresults = DB::table('machines')
            ->join('machines', 'machine.machine_code', '=', 'machines.machine_name')
            ->leftJoin('componenchecks', function ($join) {
                $join->on('machines.machine_code', '=', 'componenchecks.machine_code_componencheck');
            })
            ->leftJoin('parameters', function ($join) {
                $join->on('componenchecks.id_componencheck', '=', 'parameters.componencheck_parameter');
            })
            ->leftJoin('metodechecks', function ($join) {
                $join->on('paramters.id_parameter', '=', 'metodechecks.parameter_metodecheck');
            })
            ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
            ->get();
            */
        return view('dashboard.view_hasilmesin.tablemesinresult', ['machines' => $machine]);
    }
    public function indextablemachine()
    {
        $machines=Machine::get();
        return view ('dashboard.view_mesin.tablemachine',['machines'=>$machines]);
    }

    public function indexregistermachine()
    {
        return view ('dashboard.view_mesin.addmachine');
    }

    public function indexupdatemachine($id)
    {
        $machines=Machine::find($id);
        return view ('dashboard.view_mesin.editmachine',['machines'=>$machines]);
    }

    public function registermachine(Request $request)
    {
        $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();
        if (isset($lastMachineCode)) {
            $currentvalue =  $lastMachineCode->machine_code + 1;
        } else {
            $currentvalue = 1;
        }
        $request->validate([
            'invent_number' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        //simpan data
        $machines = Machine::create($request->all());
        //sembari update data nomor mesin
        $machines->machine_code = $currentvalue;
        $machines->save();

        return redirect()->route("managemachine")->withSuccess('Machine added successfully.');
    }

    public function updatemachine(Request $request, $id)
    {
        $request->validate([
            'invent_number' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        $machines = Machine::find($id);
        $machines->update($request->all());
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        return redirect()->route("managemachine")->withSuccess('Machine updated successfully.');
    }

    public function deletemachine($id)
    {
        Machine::where('id',$id)->delete();
        return redirect()->route("managemachine")->with('success', 'Machine deleted successfully');
    }
}
