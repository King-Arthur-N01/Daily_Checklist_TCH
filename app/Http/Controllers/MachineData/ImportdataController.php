<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Imports\Importdata;
use App\Machine;
use App\Machineproperty;
use Maatwebsite\Excel\Facades\Excel;
class ImportdataController extends Controller
{
    // fungsi index upload data mesin
    public function indeximport()
    {
        $machines = Machine::get();
        return view('dashboard.view_importdata.indeximportdata',['machines' => $machines]);
    }
    public function fetchtableimport($id)
    {
        try {
            // dd($id);
            $fetchtable = Machineproperty::find($id);
            // $fetchtable = Machineproperty::find($id);
            return response()->json(['name_property' => $fetchtable->name_property]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    // fungsi ajax untuk melihat property mesin
    public function fetchdataproperty($id)
    {
        try {
            $fetchmachines = DB::table('machines')
            ->select('machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
            ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->join('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
            ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machines.id', '=', $id)
            ->get();
            return response()->json(['fetchmachines' => $fetchmachines]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    // fungsi upload data excel ke database
    public function importdata(Request $request)
    {
        $request->validate([
            'file' => 'mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new Importdata, $request->file('file'));
            return response()->json(['success' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            // Log::error('Data import error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!']);
        }
    }
}
