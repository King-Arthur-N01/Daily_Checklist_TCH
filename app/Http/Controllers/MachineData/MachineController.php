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
    // <<<============================================================================================>>>
    // <<<====================================batas machine result====================================>>>
    // <<<============================================================================================>>>
    public function indextablemachineresult(){
        $machines = DB::table('machines')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->orderBy('machines.id', 'asc')
        ->get();
        return view('dashboard.view_hasilmesin.tablemesinresult', ['machines' => $machines]);
    }
    public function indexregistermachineresult(){
        $machines = Machine::all('machine_name', 'id');
        $componenchecks = Componencheck::all('name_componencheck', 'id');
        $parameters = Parameter::all('name_parameter', 'id');
        $metodechecks = Metodecheck::all('name_metodecheck', 'id');

        return view('dashboard.view_hasilmesin.addmesinresult',[
            'machines' => $machines,
            'componenchecks' => $componenchecks,
            'parameters' => $parameters,
            'metodechecks' => $metodechecks
        ]);
    }
    // <<<============================================================================================>>>
    // <<<==================================batas machine result end==================================>>>
    // <<<============================================================================================>>>

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
        // $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();
        // if (isset($lastMachineCode)) {
        //     $currentvalue =  $lastMachineCode->machine_code + 1;
        // } else {
        //     $currentvalue = 1;
        // }
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        //simpan data
        // $machines = Machine::create($request->all());
        //sembari update data nomor mesin
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        Machine::create($request->all());
        return redirect()->route("managemachine")->withSuccess('Machine added successfully.');
    }

    public function updatemachine(Request $request, $id)
    {
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        dd($request);
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
