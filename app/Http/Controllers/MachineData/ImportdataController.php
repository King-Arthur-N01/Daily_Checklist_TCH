<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Imports\Importdata;
use App\Machine;
use Maatwebsite\Excel\Facades\Excel;
class ImportdataController extends Controller
{
    // fungsi index view upload data mesin
    public function indexmachineimport()
    {
        $machines=Machine::get();
        return view('dashboard.view_importdata.indeximportdata',['machines' => $machines]);
    }
    // fungsi upload data excel ke model
    public function importdata(Request $request)
    {
        $request->validate([
            'file' => 'mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new Importdata, $request->file('file'));
            return response()->json(['success' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            Log::error('Data import error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!']);
        }
    }
}
