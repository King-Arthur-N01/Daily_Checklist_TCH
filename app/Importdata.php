<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Machines;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
use Maatwebsite\Excel\Concerns\ToModel;

class Importdata extends Model
{
    public function import(array $row)
    {
        // table 1
        if ($row[0] == 'Condition1') {
            return new Machines([
                'id' => $row[0],
                'invent_number' => $row[1],
                'machine_number' => $row[2],
                'machine_name' => $row[3],
                'machine_brand' => $row[4],
                'machine_type' => $row[5],
                'machine_spec' =>  $row[6],
                'machine_made' => $row[7],
                'mfg_number' => $row[8],
                'install_date' => $row[9]
            ]);
        }
        //table 2
        if ($row[0] == 'Condition2') {
            return new Componencheck([
                'name_componencheck' => $row[10],
                // Add more columns as needed
            ]);
        // table 3
        }elseif ($row[1] == 'Condition3') {
            return new Parameter([
                'name_parameter' => $row[11],
                // Add more columns as needed
            ]);
        // table 4
        }elseif ($row[2] == 'Condition4') {
            return new Metodecheck([
                'name_metodecheck' => $row[12],
                // Add more columns as needed
            ]);
        }
    }
}