<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componencheck extends Model
{
    protected $fillable = [
        'id_machine',
        'name_componencheck'
    ];
    public function getparentmachine()
    {
        return $this->hasMany(Machine::class);
    }
    public function getchildernparameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
