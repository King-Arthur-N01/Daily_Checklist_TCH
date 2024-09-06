<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'schedule_name',
        'schedule_time',
        'schedule_record',
        'schedule_next',
        'id_machine'
    ];
}
