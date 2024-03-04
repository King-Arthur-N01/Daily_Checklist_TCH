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
        ->join('parameters', 'metodechecks.id_parameter', '=', 'parameters.id')
        ->join('componenchecks', 'parameters.id_componencheck', '=', 'componenchecks.id')
        ->join('machines', 'componenchecks.id_machine', '=', 'machines.id')
        ->select('metodechecks.*', 'componenchecks.*', 'parameters.*', 'machines.*')
        ->orderBy('metodechecks.id', 'asc')
        ->get();
        return view ('dashboard.view_metode.tablemethod',['metodechecks'=>$metodechecks]);
    }
    public function indexregistermethod()
    {
        $parameters = Parameter::all('name_parameter', 'id');
        return view ('dashboard.view_metode.addmethod',['parameters'=>$parameters]);
    }

    public function indexeditmethod($id)
    {
        $metodechecks=Metodecheck::find($id);
        return view ('dashboard.view_metode.editmethod',['metodechecks'=>$metodechecks]);
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
