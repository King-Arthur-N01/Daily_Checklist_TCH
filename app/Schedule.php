<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name_schedule',
        'machine_collection',
        'schedule_status'
    ];

    public function getchildernmachineschedule()
    {
        return $this->belongsTo(MachineSchedule::class);
    }
    public function getchildernplannedschedule()
    {
        return $this->belongsTo(PlannedSchedule::class);
    }
}
