<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineproperty;
use app\Componencheck;
use App\Parameter;
use App\Metodecheck;
use Illuminate\Http\Request;
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
        dd($request);
        try {
            $StoreProperty = new Machineproperty();
            $StoreProperty->name_property = $request->input('name_property');
            $StoreProperty->save();

            $machinepropertyid = Machineproperty::latest('id')->first()->id;

            $bagianYangDicheck = $request->input('bagian_yang_dicheck');
            $standartParameter = $request->input('standart_parameter');
            $metodePengecekan = $request->input('metode_pengecekan');

            foreach ($bagianYangDicheck as $key => $value) {
                $StoreComponent = new Componencheck();
                $StoreComponent->name_componencheck = $value;
                $StoreComponent->id_property2 = $machinepropertyid;
                $StoreComponent->save();

                $componencheckid = Componencheck::latest('id')->first()->id;

                $StoreParameter = new Parameter();
                $StoreParameter->name_parameter = $standartParameter[$key];
                $StoreParameter->id_componencheck = $componencheckid;
                $StoreParameter->save();

                $parameterid = Parameter::latest('id')->first()->id;

                $StoreMetode = new Metodecheck();
                $StoreMetode->name_metodecheck = $metodePengecekan[$key];
                $StoreMetode->id_parameter = $parameterid;
                $StoreMetode->save();
            }
        } catch (\Exception $e) {
            // handle exception
        }
    }
}
