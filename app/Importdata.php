<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
class Importdata extends Model
{
    public function import(array $row)
    {
        // table 1
        if ($row[0] == 'Condition1') {
            return new Componencheck([
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
        // table 2
        }elseif ($row[0] == 'Condition2') {
            return new Parameter([
                'column1' => $row[1],
                'column2' => $row[2],
                // Add more columns as needed
            ]);
        // table 3
        }else {
            return new Metodecheck([
                'column1' => $row[1],
                'column2' => $row[2],
                // Add more columns as needed
            ]);
        }
    }
}
