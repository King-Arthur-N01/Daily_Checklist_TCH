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
    ];
    public function getchildernproperty()
    {
        return $this->belongsTo(Machineproperty::class);
    }
    public function getchildernrecord()
    {
        return $this->belongsTo(MachineSchedule::class);
    }
    public function getchildernschedule()
    {
        return $this->belongsTo(Machinerecord::class);
    }
}
