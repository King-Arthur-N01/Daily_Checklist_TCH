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
        $machines = Machine::get();
        return view('dashboard.view_importdata.tableimportdata', ['machines' => $machines]);
    }

    // fungsi untuk merefresh tabel form prefentive
    public function refreshtableimport()
    {
        try {
            $refreshmachine = Machine::all();
            $refreshproperty = Machineproperty::all();
            $refreshschedule= Schedule::all();
            return response()->json([
                'refreshmachine' => $refreshmachine,
                'refreshproperty' => $refreshproperty,
                'refreshschedule' => $refreshschedule
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
    public function readmachinedata($id)
    {
        try {
            $fetchmachine = Machine::find($id);
            $fetchproperty = Machineproperty::get();
            $fetchschedule = Schedule::get();
            return response()->json([
                'fetchmachine' => $fetchmachine,
                'fetchproperty' => $fetchproperty,
                'fetchschedule' => $fetchschedule
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // fungsi untuk mengupload data mesin
    public function notuseregisteridproperty(Request $request, $id)
    {
        $request->validate([
            'id_property' => 'required'
        ]);
        $registerproperty = Machine::find($id);
        if (!$registerproperty) {
            return response()->json(['error' => 'Data mesin tidak berhasil ditemukan !!!!'], 404);
        } else {
            $registerproperty->update(['id_property' => $request->input('id_property')]);
        }
        return response()->json(['success' => 'Standarisasi mesin berhasil di UPDATE!']);
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
            return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!'], 500);
        }
    }
    public function exportpdf($id)
    {
        try {
            $joinmachine = DB::table('machines')
                ->select('machines.*', 'machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*', 'metodechecks.id as metodecheck_id')
                ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
                ->join('componenchecks', 'componenchecks.id_property2', '=', 'machineproperties.id')
                ->join('parameters', 'parameters.id_componencheck', '=', 'componenchecks.id')
                ->join('metodechecks', 'metodechecks.id_parameter', '=', 'parameters.id')
                ->where('machines.id', '=', $id)
                ->get();

            // Convert collection to array
            // $machinedata = get_object_vars($joinmachine);
            $machinedata = $joinmachine->toArray();

            // Render PDF
            $pdf = PDF::loadView('dashboard.view_importdata.viewprintpdf', compact('machinedata'));
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream();
            // return $pdf->download('data.pdf');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('DOM PDF failed: '.$e->getMessage());

            return response()->json(['error' => 'Data Preventive FAILED to be downloaded!']);
        }
    }

}
