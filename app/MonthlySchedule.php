<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlySchedule extends Model
{
    protected $fillable = [
        'schedule_duration',
        'schedule_time',
        'schedule_record',
        'id_schedule2',
    ];

    public function getparentschedule()
    {
        return $this->hasMany(YearlySchedule::class);
    }

    public function getchildernrecord()
    {
        return $this->belongsTo(Machinerecord::class);
    }
}
