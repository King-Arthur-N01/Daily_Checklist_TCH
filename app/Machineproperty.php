<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machineproperty extends Model
{
    protected $fillable = [
        'standart_name'
    ];
    public function getchilderncomponen()
    {
        return $this->hasMany(Componencheck::class);
    }
}
