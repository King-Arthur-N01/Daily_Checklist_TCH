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
        $machines = DB::table('machines')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->select('machines.*','componenchecks.*')
        ->orderBy('machines.id', 'asc')
        ->get();
        return view ('dashboard.view_componen.tablecomponencheck',['machines'=>$machines]);
    }
    public function indexregistercomponencheck()
    {
        $machines = Machine::all('machine_name', 'id');
        return view ('dashboard.view_componen.addcomponencheck',['machines' => $machines]);
    }

    public function indexeditcomponencheck($id)
    {
        $machines = Machine::all('machine_name', 'id');
        $componenchecks=Componencheck::find($id);
        return view ('dashboard.view_componen.editcomponencheck',['componenchecks'=>$componenchecks, 'machines' => $machines]);
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
        return redirect()->route("managecomponencheck")->with('success', 'Componen deleted successfully');
    }
}
