<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Imports\Importdata;
use Maatwebsite\Excel\Facades\Excel;
class ImportdataController extends Controller
{
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
    // public function importdata(Request $request){
    //     $base64Data = $request->input('fileupload');
    //     if ($base64Data) {
    //         $decodedData = base64_decode($base64Data);
    //         $tempfile = tempnam(sys_get_temp_dir(), 'decoded_excel');
    //         file_put_contents($tempfile, $decodedData);
    //         $import = new Importdata();
    //         Excel::import($import, $tempfile);
    //         unlink($tempfile);
    //         return response()->json(['success' => 'Data imported successfully!']);
    //     }
    //     return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!']);
    // }
    // public function importdata(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'mimes:xlsx,xls,csv',
    //     ]);

    //     try {
    //         $import = new Importdata;
    //         Excel::import($import, $request->file('file'));

    //         // Retrieve the row keys from the Importdata class
    //         $rowKeys = [];
    //         foreach ($import->rows as $row) {
    //             $rowKeys[] = $row->rowKey;
    //         }

    //         // Do something with the row keys, e.g. log them or store them in a database
    //         Log::info('Row keys: ' . implode(', ', $rowKeys));

    //         return response()->json(['success' => 'Data imported successfully!']);
    //     } catch (\Exception $e) {
    //         Log::error('Data import error: ' . $e->getMessage(), ['exception' => $e]);
    //         return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!']);
    //     }
    // }
}
