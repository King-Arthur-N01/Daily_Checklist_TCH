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
        ->select('machineproperties.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*', 'machineproperties.id as property_id')
        ->join('componenchecks', 'machineproperties.id', '=', 'componenchecks.id_property2')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->get();
        return view ('dashboard.view_propertymesin.indexpropertymesin',['joinproperty'=>$joinproperty]);
    }
}
