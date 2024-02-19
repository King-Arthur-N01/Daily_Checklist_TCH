<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machineresult extends Model
{
    protected $fillable = [
        'machine_code',
        'id_componencheck1',
        'id_componencheck2',
        'id_componencheck3',
        'id_componencheck4',
        'id_componencheck5',
        'id_componencheck6',
        'id_parameter1',
        'id_parameter2',
        'id_parameter3',
        'id_parameter4',
        'id_parameter5',
        'id_parameter6',
        'id_metodecheck1',
        'id_metodecheck2',
        'id_metodecheck3',
        'id_metodecheck4',
        'id_metodecheck5',
        'id_metodecheck6'
    ];
}
