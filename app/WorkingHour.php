<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = [
        'standart_name',
        'priority',
        'preventive_hour',
        'man_power'
    ];

    public function getmachinechildren()
    {
        return $this->belongsTo(Machine::class);
    }
}
