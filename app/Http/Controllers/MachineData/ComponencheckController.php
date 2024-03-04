<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use App\Componencheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComponencheckController extends Controller
{
    public function indextablecomponencheck()
    {
        $componenchecks = DB::table('componenchecks')
        ->join('machines', 'componenchecks.id', '=', 'machines.id')
        ->select('componenchecks.*', 'machines.*')
        ->orderBy('componenchecks.id', 'asc')
        ->get();
        return view ('dashboard.view_componen.tablecomponencheck',['componenchecks'=>$componenchecks]);
    }
    public function indexregistercomponencheck()
    {
        $machines = Machine::all('machine_name', 'id');
        return view ('dashboard.view_componen.addcomponencheck',['machines' => $machines]);
    }

    public function indexeditcomponencheck($id)
    {
        $componenchecks = DB::table('componenchecks')
        ->join('machines', 'componenchecks.id_componencheck', '=', 'machines.id')
        ->select('componenchecks.*', 'machines.machine_name')
        ->orderBy('componenchecks.id', 'asc')
        ->get();
        $componenchecks=Componencheck::find($id);
        return view ('dashboard.view_componen.editcomponencheck',['componenchecks'=>$componenchecks]);
    }

    public function registercomponencheck(Request $request)
    {
        // dd($request);
        $request->validate([
            'id_machine' => 'required',
            'name_componencheck' => 'required|max:255'
        ]);
        Componencheck::create($request->all());
        return redirect()->route("managecomponencheck")->withSuccess('Componencheck added successfully.');
    }

    public function editcomponencheck(Request $request, $id)
    {
        $request->validate([
            'id_machine' => 'required',
            'name_componencheck' => 'required|max:255'
        ]);
        $componenchecks = Componencheck::find($id);
        $componenchecks->update($request->all());
        return redirect()->route("managecomponencheck")->withSuccess('Componen updated successfully.');
    }

    public function deletecomponencheck($id)
    {
        Componencheck::where('id',$id)->delete();
        return redirect()->route("managemanagecomponencheck")->with('success', 'Componen deleted successfully');
    }
}
