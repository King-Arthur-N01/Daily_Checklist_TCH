<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name_schedule',
        'id_machine',
        'schedule_status'
    ];

    public function getchildernmachineschedule()
    {
        return $this->belongsTo(MachineSchedule::class);
    }
}
