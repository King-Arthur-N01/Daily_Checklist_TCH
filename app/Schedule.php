<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'schedule_time',
        'schedule_record',
        'schedule_next',
        'id_machine2'
    ];
    public function getparentcomponen()
    {
        return $this->hasMany(Componencheck::class);
    }
}
