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
        // dd($request->all());
        try {
            Excel::import(new Importdata, $request->file('file'));
            return response()->json(['success' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            Log::error('Data import error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!']);
        }
    }
    // public function importdata(REQUEST $request){

    //     $base64Data = $request->input('file');

    //     if ($base64Data) {
    //         $decodedData = base64_decode($base64Data);
    //         $tempFile = tempnam(sys_get_temp_dir(), 'decoded_excel');
    //         file_put_contents($tempFile, $decodedData);
    //         $import = new Importdata();
    //         Excel::import($import, $tempFile);
    //         unlink($tempFile);
    //         return response()->json(['message' => 'Data berhasil diimpor ke database.']);
    //     }
    //     return response()->json(['message' => 'Data Base64 tidak ditemukan atau tidak valid.'], 400);
    // }
}
