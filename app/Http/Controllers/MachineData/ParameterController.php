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
    public function indexparameter()
    {
        $parameters = DB::table('machineproperties')
        ->join('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->select('machineproperties.*','parameters.*', 'componenchecks.*')
        ->orderBy('machineproperties.id', 'asc')
        ->get();
        return view ('dashboard.view_parameter.tableparameter',['parameters'=>$parameters]);
    }
    public function registerparameter()
    {
        $componenchecks = Componencheck::all('name_componencheck', 'id');
        return view ('dashboard.view_parameter.addparameter',['componenchecks'=>$componenchecks]);
    }

    public function editparameter($id)
    {
        $componenchecks = Componencheck::all('name_componencheck', 'id');
        $parameters=Parameter::find($id);
        return view ('dashboard.view_parameter.editparameter',['parameters'=>$parameters,'componenchecks'=>$componenchecks]);
    }

    public function pushregisterparameter(Request $request)
    {
        $request->validate([
            'id_componencheck'  => 'required',
            'name_parameter' => 'required|max:255'
        ]);
        Parameter::create($request->all());
        return redirect()->route("manageparameter")->withSuccess('Parameter added successfully.');
    }

    public function pusheditparameter(Request $request, $id)
    {
        $request->validate([
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
