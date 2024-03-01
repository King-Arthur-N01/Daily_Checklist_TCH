<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MetodecheckController extends Controller
{
    public function indextablemethod()
    {
        $metodechecks = DB::table('metodechecks')
        ->join('parameters', 'metodechecks.parameter_metodecheck', '=', 'parameters.id_parameter')
        ->select('metodechecks.*', 'parameters.name_parameter')
        ->orderBy('metodechecks.id', 'asc')
        ->get();
        return view ('dashboard.view_metode.tablemethod',['metodechecks'=>$metodechecks]);
    }
    public function indexregistermethod()
    {
        $parameters= Parameter::all('name_parameter', 'id_parameter');
        return view ('dashboard.view_metode.addmethod',['parameters'=>$parameters]);
    }

    public function indexeditmethod($id)
    {
        $metodechecks=Metodecheck::find($id);
        return view ('dashboard.view_metode.editmethod',['metodechecks'=>$metodechecks]);
    }

    public function registermethod(Request $request)
    {
        $lastIDCode = Metodecheck::orderBy('id_metodecheck', 'desc')->first();
        if (isset($lastIDCode)) {
            $currentvalue =  $lastIDCode->id_metodecheck + 1;
        } else {
            $currentvalue = 1;
        }
        $request->validate([
            'parameter_metodecheck'=> 'required',
            'name_metodecheck' => 'required|max:255'
        ]);
        $metodecheck = Metodecheck::create($request->all());
        $metodecheck->id_metodecheck = $currentvalue;
        $metodecheck->save();
        return redirect()->route("managemethod")->withSuccess('Machine added successfully.');
    }

    public function editmethod(Request $request, $id)
    {
        $request->validate([
            'parameter_metodecheck' => 'required',
            'id_metodecheck',
            'name_metodecheck' => 'required|max:255'
        ]);
        $Metodechecks = Metodecheck::find($id);
        $Metodechecks->update($request->all());
        return redirect()->route("managemethod")->withSuccess('Items updated successfully.');
    }

    public function deletemethod($id)
    {
        Metodecheck::where('id',$id)->delete();
        return redirect()->route("managemethod")->with('success', 'Parameter deleted successfully');
    }
}
