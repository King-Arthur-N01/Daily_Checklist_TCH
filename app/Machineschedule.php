<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machineschedule extends Model
{
    protected $fillable = [
        'schedule_start',
        'schedule_end',
        'schedule_record',
        'schedule_next',
        'start_date',
        'finish_date',
        'id_machine3',
        'machineschedule_status',
        'id_machinerecord',
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
