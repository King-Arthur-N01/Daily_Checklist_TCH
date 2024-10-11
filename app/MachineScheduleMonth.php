<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineScheduleMonth extends Model
{
    protected $fillable = [
        'schedule_duration',
        'schedule_date',
        'schedule_record',
        'id_schedule2',
        'machineschedule_status'
    ];

    public function getparentschedule()
    {
        return $this->hasMany(MonthlySchedule::class);
    }
    public function getchildernrecord()
    {
        return $this->belongsTo(Machinerecord::class);
    }
}
