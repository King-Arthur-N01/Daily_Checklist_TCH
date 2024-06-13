<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineproperty;
use App\Componencheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComponencheckController extends Controller
{
    public function indexcomponencheck()
    {
        $componenchecks = DB::table('machineproperties')
        ->join('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
        ->select('machineproperties.*','componenchecks.*')
        ->orderBy('machineproperties.id', 'asc')
        ->get();
        return view ('dashboard.view_componen.tablecomponencheck',['componenchecks'=>$componenchecks]);
    }
    public function registercomponencheck()
    {
        $machines = Machineproperty::all('standart_name', 'id');
        return view ('dashboard.view_componen.addcomponencheck',['machines' => $machines]);
    }

    public function editcomponencheck($id)
    {
        $machineproperties = Machineproperty::all('standart_name', 'id');
        $componenchecks=Componencheck::find($id);
        return view ('dashboard.view_componen.editcomponencheck',['componenchecks'=>$componenchecks, 'machinesproperty' => $machineproperties]);
    }

    public function pushregistercomponencheck(Request $request)
    {
        // dd($request);
        $request->validate([
            'id_property2' => 'required',
            'name_componencheck' => 'required|max:255'
        ]);
        Componencheck::create($request->all());
        return redirect()->route("managecomponencheck")->withSuccess('Componencheck added successfully.');
    }

    public function pusheditcomponencheck(Request $request, $id)
    {
        $request->validate([
            'id_property2' => 'required',
            'name_componencheck' => 'required|max:255'
        ]);
        $componenchecks = Componencheck::find($id);
        $componenchecks->update($request->all());
        return redirect()->route("managecomponencheck")->withSuccess('Componen updated successfully.');
    }

    public function deletecomponencheck($id)
    {
        Componencheck::where('id',$id)->delete();
        return redirect()->route("managecomponencheck")->with('success', 'Componen deleted successfully');
    }
}
