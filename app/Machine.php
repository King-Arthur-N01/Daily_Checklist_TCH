<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'machine_code',
        'invent_number',
        'machine_name',
        'machine_brand',
        'machine_type',
        'machine_spec',
        'machine_made',
        'mfg_number',
        'install_date'
    ];
    public function getchilderncomponen()
    {
        return $this->belongsTo(Componencheck::class);
    }
}
