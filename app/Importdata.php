<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
class Importdata extends Model
{
    public function model(array $row)
    {
        // Example: dividing data into three tables based on some condition
        if ($row[0] == 'Condition1') {
            return new Componencheck([
                'column1' => $row[1],
                'column2' => $row[2],
                // Add more columns as needed
            ]);
        }elseif ($row[0] == 'Condition2') {
            return new Parameter([
                'column1' => $row[1],
                'column2' => $row[2],
                // Add more columns as needed
            ]);
        }else {
            return new Metodecheck([
                'column1' => $row[1],
                'column2' => $row[2],
                // Add more columns as needed
            ]);
        }
    }
}
