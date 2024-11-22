<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machineproperty extends Model
{
    protected $fillable = [
        'name_property'
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
