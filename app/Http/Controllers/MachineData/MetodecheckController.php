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
        $machines = DB::table('machines')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->select( 'machines.*', 'metodechecks.*', 'parameters.*', 'componenchecks.*')
        ->orderBy('machines.id', 'asc')
        ->get();
        return view ('dashboard.view_metode.tablemethod',['machines'=>$machines]);
    }
    public function indexregistermethod()
    {
        $parameters = Parameter::all('name_parameter', 'id');
        return view ('dashboard.view_metode.addmethod',['parameters'=>$parameters]);
    }

    public function indexeditmethod($id)
    {
        $parameters = Parameter::all('name_parameter', 'id');
        $metodechecks=Metodecheck::find($id);
        return view ('dashboard.view_metode.editmethod',['metodechecks'=>$metodechecks,'parameters'=>$parameters]);
    }

    public function registermethod(Request $request)
    {
        $request->validate([
            'id_parameter' => 'required',
            'name_metodecheck' => 'required|max:255'
        ]);
        Metodecheck::create($request->all());
        return redirect()->route("managemethod")->withSuccess('Machine added successfully.');
    }

    public function editmethod(Request $request, $id)
    {
        $request->validate([
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
