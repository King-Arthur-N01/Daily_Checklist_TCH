<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machineschedule extends Model
{
    protected $fillable = [
        'schedule_duration',
        'schedule_time',
        'schedule_record',
        'id_machine2',
        'id_schedule2',
    ];

    public function getparentmachine()
    {
        return $this->hasMany(Machine::class);
    }

    public function getparentschedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getchildernrecord()
    {
        return $this->belongsTo(Machinerecord::class);
    }
}
