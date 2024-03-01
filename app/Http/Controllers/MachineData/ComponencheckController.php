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
        $componencheck = DB::table('componenchecks')
        ->join('machines', 'componenchecks.machine_code_componencheck', '=', 'machines.machine_code')
        ->select('componenchecks.*', 'machines.machine_name')
        ->orderBy('componenchecks.id', 'asc')
        ->get();
        return view ('dashboard.view_componen.tablecomponencheck',['componencheck'=>$componencheck]);
    }
    public function indexregistercomponencheck()
    {
        $machines = Machine::all('machine_name', 'machine_code');
        return view ('dashboard.view_componen.addcomponencheck',['machines' => $machines]);
    }

    public function indexeditcomponencheck($id)
    {
        $componenchecks = DB::table('componenchecks')
        ->join('machines', 'componenchecks.machine_code_componencheck', '=', 'machines.machine_code')
        ->select('componenchecks.*', 'machines.machine_name')
        ->orderBy('componenchecks.id', 'asc')
        ->get();
        $componenchecks=Componencheck::find($id);
        return view ('dashboard.view_componen.editcomponencheck',['componenchecks'=>$componenchecks]);
    }

    public function registercomponencheck(Request $request)
    {
        $lastIDCode = Componencheck::orderBy('id_componencheck', 'desc')->first();
        if (isset($lastIDCode)) {
            $currentvalue =  $lastIDCode->id_componencheck + 1;
        } else {
            $currentvalue = 1;
        }
        $request->validate([
            'machine_code_componencheck'=>'required',
            'name_componencheck' => 'required|max:255'
        ]);
        $componencheck = Componencheck::create($request->all());
        $componencheck->id_componencheck = $currentvalue;
        $componencheck->save();
        return redirect()->route("managecomponencheck")->withSuccess('Componen Check added successfully.');
    }

    public function editcomponencheck(Request $request, $id)
    {
        $request->validate([
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
