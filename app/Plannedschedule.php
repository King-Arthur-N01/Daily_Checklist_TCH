<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plannedschedule extends Model
{
    protected $fillable = [
        'schedule_start',
        'schedule_end',
        'schedule_next',
        'schedule_status',
        'id_machine',
        'id_schedule'
    ];
}
