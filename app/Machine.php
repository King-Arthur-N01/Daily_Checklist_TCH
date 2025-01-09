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
        'machine_power',
        'machine_made',
        'machine_status',
        'machine_info',
        'mfg_number',
        'install_date',
        'production_date',
        'machine_abnormal_status',
        'machine_problem',
        'machine_action',
        'id_property',
        'id_working',
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
