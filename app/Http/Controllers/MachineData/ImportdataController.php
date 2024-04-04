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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $file = $request->file('file');
        Excel::import(new Importdata, $file);
        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
