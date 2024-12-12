<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Importdata;
use App\Machine;
use App\Machineproperty;
use App\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ImportdataController extends Controller
{
    // fungsi index upload data mesin
    public function indeximport()
    {
        $fetchmachines = DB::table('machines')
            ->select('machines.*', 'machineproperties.*')
            ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->get();
        // $machines = Machine::get();
        // $property = Machineproperty::get();
        return view('dashboard.view_importdata.tableimportdata', [
            'fetchmachines' => $fetchmachines
        ]);
    }

    // fungsi untuk merefresh tabel form prefentive
    public function refreshtableimport()
    {
        try {
            $refreshmachine = Machine::all();
            $refreshproperty = Machineproperty::all();
            return response()->json([
                'refreshmachine' => $refreshmachine,
                'refreshproperty' => $refreshproperty,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi ajax untuk melihat property mesin
    public function detailproperty($id)
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

    // fungsi fetchdata setiap mesin
    public function findmachine($id)
    {
        try {
            $fetchmachine = Machine::find($id);
            $fetchproperty = Machineproperty::get();
            return response()->json([
                'fetchmachine' => $fetchmachine,
                'fetchproperty' => $fetchproperty
            ]);
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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function printdatamachine($id)
    {
        try {
            $machinedata = DB::table('machines')
            ->select('machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*', 'metodechecks.id as metodecheck_id')
            ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->join('componenchecks', 'componenchecks.id_property2', '=', 'machineproperties.id')
            ->join('parameters', 'parameters.id_componencheck', '=', 'componenchecks.id')
            ->join('metodechecks', 'metodechecks.id_parameter', '=', 'parameters.id')
            ->where('machines.id', '=', $id)
            ->get()
            ->map(function ($item) {
                foreach ($item as $key => $value) {
                    if ($value === null || $value === 'null') {
                        $item->$key = '-';
                    }
                }
                return $item;
            });

            // Render PDF
            $pdf = PDF::loadView('dashboard.view_importdata.printmachine', compact('machinedata'));
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream();
            // return $pdf->download('data.pdf');
        } catch (\Exception $e) {
            Log::error('DOM PDF failed: '.$e->getMessage());
            return response()->json(['error' => 'Error getting data']);
        }
    }

}
