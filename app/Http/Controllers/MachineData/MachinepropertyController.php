<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineproperty;
use App\Componencheck;
use App\Importdata;
use App\Machine;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MachinepropertyController extends Controller
{
    public function indexmachineproperty()
    {
        return view('dashboard.view_propertymesin.indexpropertymesin');
    }

    public function refreshtableproperty()
    {
        try {
            $getproperty = DB::table('machineproperties')
            ->select('machineproperties.*', DB::raw('COUNT(DISTINCT componenchecks.id) as componencheck_count'), DB::raw('COUNT(DISTINCT parameters.id) as parameter_count'), DB::raw('COUNT(DISTINCT metodechecks.id) as metodecheck_count'))
            ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->groupBy('machineproperties.id')
            ->get();
            return response()->json([
                'getproperty' => $getproperty
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }

    // public function findproperty($id)
    // {
    //     try {
    //         $joinproperty = DB::table('machineproperties')
    //             ->select('machineproperties.id', 'componenchecks.id', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'componenchecks.id as join_id')
    //             ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
    //             ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
    //             ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
    //             ->where('machineproperties.id', '=', $id)
    //             ->get();

    //         $joincomponent = DB::table('machineproperties')
    //             ->select('machineproperties.*', 'componenchecks.name_componencheck', 'componenchecks.id as componen_id')
    //             ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
    //             ->where('machineproperties.id', '=', $id)
    //             ->get();

    //         return response()->json([
    //             'joinproperty' => $joinproperty,
    //             'joincomponent' => $joincomponent
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error fetching data'], 500);
    //     }
    // }

    // fungsi upload data excel ke database
    public function importpropertydata(Request $request)
    {
        $request->validate([
            'file' => 'mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new Machineproperty, $request->file('file'));
            return response()->json(['success' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            Log::error('Data import error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createproperty(Request $request)
    {
        try {
            // dd($request)->all();
            $StoreProperty = new Machineproperty();
            $StoreProperty->name_property = $request->input('name_property');
            $StoreProperty->save();

            $machinepropertyid = Machineproperty::latest('id')->first()->id;

            foreach ($request->all() as $key => $dataRow) {
                if (strpos($key, 'dataRows_') === 0) {
                    $componentChecks = $dataRow['componencheck'];
                    $parameters = $dataRow['parameter'];
                    $checkMethods = $dataRow['metodecheck'];
                    $userInputCount = (int) $dataRow['user_input_count'];

                    $StoreComponent = new Componencheck();
                    $StoreComponent->name_componencheck = $componentChecks[0];
                    $StoreComponent->id_property = $machinepropertyid;
                    $StoreComponent->save();

                    $componencheckid = Componencheck::latest('id')->first()->id;

                    for ($i = 0; $i < $userInputCount; $i++) {
                        $StoreParameter = new Parameter();
                        $StoreParameter->name_parameter = $parameters[$i];
                        $StoreParameter->id_componencheck = $componencheckid;
                        $StoreParameter->save();

                        $parameterid = Parameter::latest('id')->first()->id;

                        $StoreMethod = new Metodecheck();
                        $StoreMethod->name_metodecheck = $checkMethods[$i];
                        $StoreMethod->id_parameter = $parameterid;
                        $StoreMethod->save();
                    }
                }
                return response()->json(['success' => 'Machine property created successfully.']);
            }
        } catch (\Exception $e) {
            // Log::error('Error adding property: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error machine property failed to add!!!!'], 500);
        }
    }

    public function updateproperty(Request $request, $id)
    {
        try {
            $StoreProperty = Machineproperty::find($id);
            $StoreProperty->name_property = $request->input('name_property');
            $StoreProperty->save();

            $property_id = $StoreProperty->id;

            $joinproperty = DB::table('machineproperties')
                ->select('machineproperties.id', 'componenchecks.id', 'parameters.id', 'metodechecks.id',
                        'machineproperties.id as property_id', 'componenchecks.id as componen_id', 'parameters.id as parameter_id')
                ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
                ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
                ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
                ->where('machineproperties.id', '=', $id)
                ->get();

            // Delete each related record
            foreach ($joinproperty as $property) {
                DB::table('componenchecks')->where('id_property2', $property->property_id)->delete();
                DB::table('parameters')->where('id_componencheck', $property->componen_id)->delete();
                DB::table('metodechecks')->where('id_parameter', $property->parameter_id)->delete();
            }

            // Memproses semua dataRows
            foreach ($request->all() as $key => $dataRow) {
                if (strpos($key, 'dataRows_') === 0) {
                    $componentChecks = $dataRow['componencheck'];
                    $parameters = $dataRow['parameter'];
                    $checkMethods = $dataRow['metodecheck'];
                    $userInputCount = (int) $dataRow['user_input_count'];

                    $StoreComponent = new Componencheck();
                    $StoreComponent->name_componencheck = $componentChecks[0];
                    $StoreComponent->id_property2 = $property_id;
                    $StoreComponent->save();

                    $componencheckid = $StoreComponent->id; // Ambil ID dari objek yang baru disimpan

                    for ($i = 0; $i < $userInputCount; $i++) {
                        $StoreParameter = new Parameter();
                        $StoreParameter->name_parameter = $parameters[$i];
                        $StoreParameter->id_componencheck = $componencheckid;
                        $StoreParameter->save();

                        $parameterid = $StoreParameter->id; // Ambil ID dari objek yang baru disimpan

                        $StoreMethod = new Metodecheck();
                        $StoreMethod->name_metodecheck = $checkMethods[$i];
                        $StoreMethod->id_parameter = $parameterid;
                        $StoreMethod->save();
                    }
                }
            }
            return response()->json(['success' => 'Machine property updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Error adding property: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error machine property failed to update!!!!'], 500);
        }
    }
    public function deleteproperty($id)
    {
        try {
            $deleteproperty = Machineproperty::where('id', $id)->delete();
            if ($deleteproperty > 0) {
                return response()->json(['success' => 'Data property berhasil dihapus.']);
            } else {
                return response()->json(['error' => 'Data property gagal dihapus!'], 422);
            }
        } catch (\Exception $e) {
            // Log::error('Error delete property: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Property failed to delete!!!!'], 500);
        }
    }
}
