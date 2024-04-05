<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Importdata;
use Maatwebsite\Excel\Facades\Excel;

class ImportdataController extends Controller
{
    public function indextableexle()
    {

        return view('dashboard.view_importdata.tableimportdata');
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
    public function uploadData(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads'), $filename);

            // Import the data from the uploaded file
            Excel::import(new Importdata, public_path('assets/uploads' . $filename));
            return response()->json(['success' => 'File uploaded successfully.']);
        }
        return response()->json(['error' => 'No file selected.']);
    }
}
