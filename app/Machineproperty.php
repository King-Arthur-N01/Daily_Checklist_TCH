<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machineproperty extends Model
{
    protected $fillable = [
        'name_property',
        'standart_checksheet'
    ];

    public function getparentmachine()
    {
        return $this->hasMany(Machine::class);
    }
    public function getchilderncomponen()
    {
        return $this->hasMany(Componencheck::class);
    }
}
