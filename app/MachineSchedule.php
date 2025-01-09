<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineSchedule extends Model
{
    protected $fillable = [
        'schedule_start',
        'schedule_end',
        'schedule_date',
        'schedule_record',
        'machine_schedule_status',
        'yearly_id',
        'monthly_id',
        'record_repair_id',
    ];

    public function getparentschedule()
    {
        return $this->hasMany(YearlySchedule::class);
    }
    public function getparentuser()
    {
        return $this->hasMany(User::class);
    }
}
