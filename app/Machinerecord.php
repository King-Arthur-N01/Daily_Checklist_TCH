<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machinerecord extends Model
{
    protected $fillable = [
        'id_machinerecord',
        'action_check',
        'action_cleaning',
        'action_adjust',
        'action_replace'
    ];
    public function getparentmachine()
    {
        return $this->hasMany(Machine::class);
    }
}
