<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historyrecords extends Model
{
    protected $fillable = [
    'id_metodecheck',
    'operator_action',
    'result',
    'id_machinerecord'
    ];
}
