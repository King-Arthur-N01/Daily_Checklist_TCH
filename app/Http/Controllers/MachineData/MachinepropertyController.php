<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineproperty;
use App\Componencheck;
use App\Machine;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MachinepropertyController extends Controller
{
    public function indexmachineproperty()
    {
        return view('dashboard.view_propertymesin.indexpropertymesin');
    }

    public function refreshtableproperty()
    {
        try {
            $joinproperty = DB::table('machineproperties')
                ->select('machineproperties.*', 'machines.*')
                ->leftJoin('machines', 'machineproperties.id', '=', 'machines.id_property')
                ->orderBy('machineproperties.id', 'asc')
                ->get();
            return response()->json([
                'joinproperty' => $joinproperty
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
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
            return response()->json(['success' => 'Data property berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data property gagal dihapus!'], 422);
        }
    }
}
