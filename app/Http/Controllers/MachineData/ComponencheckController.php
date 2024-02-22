<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Componencheck;
use Illuminate\Http\Request;

class ComponencheckController extends Controller
{
    public function indextablecomponencheck()
    {
        $componencheck=Componencheck::get();
        return view ('dashboard.view_componen.tablecomponencheck',['componencheck'=>$componencheck]);
    }
    public function indexregistercomponencheck()
    {
        return view ('dashboard.view_componen.addcomponencheck');
    }

    public function indexeditcomponencheck($id)
    {
        $componencheck=Componencheck::find($id);
        return view ('dashboard.view_componen.editcomponencheck',['componencheck'=>$componencheck]);
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
            'name_componencheck' => 'required|max:255'
        ]);
        $componencheck = Componencheck::create($request->all());
        $componencheck->id_componencheck = $currentvalue;
        $componencheck->save();
        return redirect()->route("managecomponencheck")->withSuccess('Componen Check added successfully.');
    }

    // protected function createcomponen(array $data)
    // {
    //     return Componencheck::create([
    //         'id_componencheck' => $data ['id_componencheck'],
    //         'name_componencheck' => $data ['name_componencheck']
    //     ]);
    // }

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
