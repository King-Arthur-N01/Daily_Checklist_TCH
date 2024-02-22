<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function indextableparameter()
    {
        $parameters=Parameter::get();
        return view ('dashboard.view_parameter.tableparameter',['parameters'=>$parameters]);
    }
    public function indexregisterparameter()
    {
        return view ('dashboard.view_parameter.addparameter');
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
            'name_parameter' => 'required|max:255',
        ]);
        $parameters = Parameter::create($request->all());
        $parameters->id_parameter = $currentvalue;
        $parameters->save();
        return redirect()->route("manageparameter")->withSuccess('Parameter added successfully.');
    }

    // protected function createparameter(array $data)
    // {
    //     return Parameter::create([
    //         'id_parameter' => $data ['id_parameter'],
    //         'name_parameter' => $data ['name_parameter']
    //     ]);
    // }
    public function editparameter(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name_parameter' => 'required|max:255',
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
