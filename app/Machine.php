<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'machine_code',
        'machine_name',
        'machine_brand',
        'machine_type',
        'machine_spec',
        'mfg_number',
        'invent_number'
    ];
}
