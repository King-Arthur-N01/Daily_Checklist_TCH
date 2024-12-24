<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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
        $fetchproperties = Machineproperty::all();
        return view('dashboard.view_importdata.tableimportdata', [
            'fetchproperties' => $fetchproperties
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
    public function detailmachinedata($id)
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

    // fungsi untuk print out kosongan data mesin beserta kategory checksheet nya
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

    public function exportexcel()
    {
        try {
            $machinedata = Machine::all();

            $csvHeader = ['NO.', 'NO.INVENTARIS MESIN', 'NAMA MESIN', 'BRAND/MERK', 'MODEL/TYPE', 'SPEC/OUTPUT', 'NO.MFG/SERIAL NUMBER', 'TAHUN PEMBUATAN', 'INPUT DAYA/KW', 'BUATAN/EX', 'DATANG MC/INSTALL DATE', 'KETERANGAN', 'NO.MESIN/LOKASI'];
            $output = fopen('php://output', 'w');
            ob_start();

            fputcsv($output, $csvHeader, ';');
            foreach ($machinedata as $index => $machine) {
                fputcsv($output, [
                    $index + 1,
                    $machine->invent_number,
                    $machine->machine_name,
                    $machine->machine_brand,
                    $machine->machine_type,
                    $machine->machine_spec,
                    $machine->mfg_number,
                    $machine->production_date,
                    $machine->machine_power,
                    $machine->machine_made,
                    $machine->install_date,
                    $machine->machine_info,
                    $machine->machine_number
                ], ';');
            }

            $csvContent = ob_get_clean();
            fclose($output);

            return Response::make($csvContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="DAFTAR SEMUA MESIN.csv"',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function exportexcelwithcondition($id)
    {
        try {
            $machinedata = Machine::where('id_property', $id)->get();

            $csvHeader = ['NO.', 'NO.INVENTARIS MESIN', 'NAMA MESIN', 'BRAND/MERK', 'MODEL/TYPE', 'SPEC/OUTPUT', 'NO.MFG/SERIAL NUMBER', 'TAHUN PEMBUATAN', 'INPUT DAYA/KW', 'BUATAN/EX', 'DATANG MC/INSTALL DATE', 'KETERANGAN', 'NO.MESIN/LOKASI'];
            $output = fopen('php://output', 'w');
            ob_start();

            fputcsv($output, $csvHeader, ';');
            foreach ($machinedata as $index => $machine) {
                fputcsv($output, [
                    $index + 1,
                    $machine->invent_number,
                    $machine->machine_name,
                    $machine->machine_brand,
                    $machine->machine_type,
                    $machine->machine_spec,
                    $machine->mfg_number,
                    $machine->production_date,
                    $machine->machine_power,
                    $machine->machine_made,
                    $machine->install_date,
                    $machine->machine_info,
                    $machine->machine_number
                ], ';');
            }

            $csvContent = ob_get_clean();
            fclose($output);

            return Response::make($csvContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="DAFTAR MESIN ' . $id . '.csv"',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

    public function exportpdf()
    {
        try {
            $machinedata = Machine::all();
            $id = null;

            $pdf = PDF::loadView('dashboard.view_importdata.printexportpdf', compact('machinedata','id'));
            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }
    public function exportpdfwithcondition($id)
    {
        try {
            // $machinedata = Machine::where('id_property', $id)->get();
            $machinedata = DB::table('machines')
            ->select('machines.*', 'machineproperties.*')
            ->join('machineproperties', 'machines.id_property', '=', 'machineproperties.id')
            ->where('machines.id_property', '=', $id)
            ->get();

            $pdf = PDF::loadView('dashboard.view_importdata.printexportpdf', compact('machinedata','id'));
            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error getting data'], 500);
        }
    }

}
