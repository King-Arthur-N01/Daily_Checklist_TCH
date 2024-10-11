<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineScheduleYear extends Model
{
    protected $fillable = [
        'schedule_start',
        'schedule_end',
        'schedule_next',
        'schedule_status',
        'id_machine',
        'id_schedule'
    ];

    public function getchildernmachineschedule()
    {
        return $this->belongsTo(YearlySchedule::class);
    }
    public function getchildernplannedschedule()
    {
        return $this->belongsTo(MonthlySchedule::class);
    }
}
