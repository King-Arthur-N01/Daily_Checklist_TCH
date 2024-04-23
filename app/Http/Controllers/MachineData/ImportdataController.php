<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Importdata;
use Maatwebsite\Excel\Facades\Excel;

class ImportdataController extends Controller
{
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

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv'
    //     ]);
    //     $file = $request->file('file');
    //     Excel::import(new Importdata, $file);
    //     return redirect()->back()->with('success', 'Data imported successfully.');
    // }
    // public function uploaddata(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $filename = date("Y-m-d H.i.s") . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('assets/uploads/'), $filename);

    //         // Import the data from the uploaded file
    //         Excel::import(new Importdata, public_path('assets/uploads/' . $filename));
    //         return response()->json(['success' => 'File uploaded successfully.']);
    //     } else {
    //         echo ('Please select a file!');
    //     }
    //     return response()->json(['error' => 'No file selected.']);
    // }
    public function uploaddata(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file selected.']);
        }
        $file = $request->file('file');
        $filename = date("Y-m-d H.i.s") . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/'), $filename);
        try {
            // Import the data from the uploaded file
            Excel::import(new Importdata, public_path('assets/uploads/' . $filename));
            return response()->json(['success' => 'File uploaded successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error importing file: ' . $e->getMessage()]);
        }
    }
}
