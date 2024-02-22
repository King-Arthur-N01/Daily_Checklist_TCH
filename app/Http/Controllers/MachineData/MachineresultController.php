<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineresult;
use Illuminate\Http\Request;

class MachineresultController extends Controller
{
    public function indextablemachineresult()
    {
        $emptyfield = Machineresult::all();
        // dd($emptyfield);
        // $filltertable = $emptyfield -> reject(function($emptydata){
        //     return empty($emptydata->field);
        // });
        // $filltertable=Machineresult::get();
        return view ('dashboard.view_hasilmesin.tablemesinresult',['machineresults'=> $emptyfield]);
    }

    public function indexregistermachineresult()
    {
        return view ('dashboard.view_hasilmesin.addmachine');
    }

    public function indexeditmachineresult($id)
    {
        $machineresults=Machineresult::find($id);
        return view ('dashboard.view_hasilmesin.editmachine',['machineresults'=>$machineresults]);
    }

    public function registermachineresult(Request $request)
    {
        $request->validate([
            'name_metodecheck' => 'required|max:255',
            'machine_code' => 'required',
            'id_componencheck1',
            'id_componencheck2',
            'id_componencheck3',
            'id_componencheck4',
            'id_componencheck5',
            'id_componencheck6',
            'id_componencheck7',
            'id_componencheck8',
            'id_componencheck9',
            'id_componencheck10',
            'id_componencheck11',
            'id_componencheck12',
            'id_parameter1',
            'id_parameter2',
            'id_parameter3',
            'id_parameter4',
            'id_parameter5',
            'id_parameter6',
            'id_parameter7',
            'id_parameter8',
            'id_parameter9',
            'id_parameter10',
            'id_parameter11',
            'id_parameter12',
            'id_metodecheck1',
            'id_metodecheck2',
            'id_metodecheck3',
            'id_metodecheck4',
            'id_metodecheck5',
            'id_metodecheck6',
            'id_metodecheck7',
            'id_metodecheck8',
            'id_metodecheck9',
            'id_metodecheck10',
            'id_metodecheck11',
            'id_metodecheck12'
        ]);
        Machineresult::create($request->all());
        return redirect()->route("managemachineresults")->withSuccess('Items added successfully.');
    }

    public function editmachineresult(Machineresult $machineresult)
    {
        //
    }

    public function destroy(Machineresult $machineresult)
    {
        //
    }
}
