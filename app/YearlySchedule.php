<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YearlySchedule extends Model
{
    protected $fillable = [
        'name_schedule',
        'machine_collection',
        'schedule_status'
    ];

    public function machine_schedule_year_children()
    {
        return $this->belongsTo(MachineScheduleYear::class);
    }
}
