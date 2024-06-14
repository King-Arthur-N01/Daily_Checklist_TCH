<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machineproperty;
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
}
