<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componencheck extends Model
{
    protected $fillable = [
        'id_property',
        'name_componencheck'
    ];
    public function getparentproperty()
    {
        return $this->hasMany(Machineproperty::class);
    }
    public function getchildernparameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
