<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineproperty;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MachinepropertyController extends Controller
{
    public function indexmachineproperty()
    {
        $joinproperty = DB::table('machineproperties')
            ->select('machineproperties.*', DB::raw('COUNT(DISTINCT componenchecks.id) as componencheck_count'), DB::raw('COUNT(DISTINCT parameters.id) as parameter_count'), DB::raw('COUNT(DISTINCT metodechecks.id) as metodecheck_count'))
            ->leftJoin('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->groupBy('machineproperties.id')
            ->get();
        return view('dashboard.view_propertymesin.indexpropertymesin', ['joinproperty' => $joinproperty]);
    }
    public function addproperty(Request $request)
    {
        try {
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
                    $StoreComponent->id_property2 = $machinepropertyid;
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
            }
        } catch (\Exception $e) {
            Log::error('Error adding property: '. $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
    public function deleteproperty($id) {
        $deleteproperty = Machineproperty::where('id', $id)->delete();
        if ($deleteproperty > 0) {
            return response()->json(['success' => 'Data user berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data user gagal dihapus!'], 422);
        }
    }
}
