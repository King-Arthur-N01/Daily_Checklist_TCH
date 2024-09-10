<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'invent_number',
        'machine_number',
        'machine_name',
        'machine_brand',
        'machine_type',
        'machine_spec',
        'machine_made',
        'mfg_number',
        'install_date',
        'id_property',
        'schdule_1_month',
        'schdule_3_month',
        'schdule_6_month',
        'schdule_12_month',
    ];
    public function getchildernproperty()
    {
        return $this->belongsTo(Machineproperty::class);
    }
    public function getchildernrecord()
    {
        return $this->belongsTo(Machinerecord::class);
    }
    public function getchildernschedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
