<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Componencheck;
use App\Parameter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class ParameterController extends Controller
{
    public function indextableparameter()
    {
        $machines = DB::table('machines')
        ->join('componenchecks','machines.machine_code','=','componenchecks.machine_code_componencheck')
        ->join('parameters', 'componenchecks.id_componencheck', '=', 'parameters.componencheck_parameter')
        ->select('machines.*','parameters.*', 'componenchecks.*')
        ->orderBy('parameters.id', 'asc')
        ->get();
        return view ('dashboard.view_parameter.tableparameter',['machines'=>$machines]);
    }
    public function indexregisterparameter()
    {
        $parameter = DB::table('parameters')
        ->join('machines','parameters.machine_code','=','machines.machines.code')
        ->join('componenchecks','parameters.machine_code','=','componenchecks.machine_code_componencheck')
        ->select('machines.*','parameters.*', 'componenchecks.*')
        ->orderBy('parameters.id', 'asc')
        ->get();
        return view ('dashboard.view_parameter.addparameter',['parameters'=>$parameter]);
    }

    public function indexeditparameter($id)
    {
        $parameters=Parameter::find($id);
        return view ('dashboard.view_parameter.editparameter',['parameters'=>$parameters]);
    }

    public function registerparameter(Request $request)
    {
        $lastIDCode = Parameter::orderBy('id_parameter', 'desc')->first();
        if (isset($lastIDCode)) {
            $currentvalue =  $lastIDCode->id_parameter + 1;
        } else {
            $currentvalue = 1;
        }
        $request->validate([
            'componencheck_parameter' => 'required',
            'name_parameter' => 'required|max:255'
        ]);
        $parameters = Parameter::create($request->all());
        $parameters->id_parameter = $currentvalue;
        $parameters->save();
        return redirect()->route("manageparameter")->withSuccess('Parameter added successfully.');
    }

    public function editparameter(Request $request, $id)
    {
        $request->validate([
            'componencheck_parameter' => 'required',
            'id_parameter'=>'required',
            'name_parameter' => 'required|max:255'
        ]);
        $Parameters = Parameter::find($id);
        $Parameters->update($request->all());
        return redirect()->route("manageparameter")->withSuccess('Parameter updated successfully.');
    }
    public function deleteparameter($id)
    {
        Parameter::where('id',$id)->delete();
        return redirect()->route("manageparameter")->with('success', 'Parameter deleted successfully');
    }
}
