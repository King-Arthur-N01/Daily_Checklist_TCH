<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function indextablemachine()
    {
        $machines=Machine::get();
        return view ('dashboard.view_mesin.tablemachine',['machines'=>$machines]);
    }

    public function indexregistermachine()
    {
        return view ('dashboard.view_mesin.addmachine');
    }

    public function indexupdatemachine($id)
    {
        $machines=Machine::find($id);
        return view ('dashboard.view_mesin.editmachine',['machines'=>$machines]);
    }

    public function registermachine(Request $request)
    {
        // $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();
        // if (isset($lastMachineCode)) {
        //     $currentvalue =  $lastMachineCode->machine_code + 1;
        // } else {
        //     $currentvalue = 1;
        // }
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        //simpan data
        // $machines = Machine::create($request->all());
        //sembari update data nomor mesin
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        Machine::create($request->all());
        return redirect()->route("managemachine")->withSuccess('Machine added successfully.');
    }

    public function updatemachine(Request $request, $id)
    {
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        $machines = Machine::find($id);
        $machines->update($request->all());
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        return redirect()->route("managemachine")->withSuccess('Machine updated successfully.');
    }

    public function deletemachine($id)
    {
        Machine::where('id',$id)->delete();
        return redirect()->route("managemachine")->with('success', 'Machine deleted successfully');
    }

    // <<<============================================================================================>>>
    // <<<=================================batas import machine data==================================>>>
    // <<<============================================================================================>>>
    public function indextableimport()
    {
        $machines = DB::table('machines')
        ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->orderBy('machines.id', 'asc')
        ->get();

        return view('dashboard.view_importdata.tableimportdata',[
            'machines' => $machines
        ]);
    }
    public function importexcel(Request $request)
	{
		if($request->hasFile('file')){
			$path = $request->file('file')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();
			if(!empty($data) && $data->count()){
				foreach ($data->toArray() as $key => $value) {
					if(!empty($value)){
						foreach ($value as $v) {
							$insert[] = ['title' => $v['title'], 'description' => $v['description']];
						}
					}
				}
				if(!empty($insert)){
                    Excel::insert($insert);
					return back()->with('success','Insert Record successfully.');
				}
			}
		}
		return back()->with('error','Please Check your file, Something is wrong there.');
	}
    public function importdata(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $file = $request->file('file');
        try {
            Excel::import(new Machine, $file->path());
            return redirect()->back()->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: '. $e->getMessage());
        }
    }
    // <<<============================================================================================>>>
    // <<<===============================batas import machine data end================================>>>
    // <<<============================================================================================>>>
}
