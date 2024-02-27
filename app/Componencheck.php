<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componencheck extends Model
{
    protected $fillable = [
        'id_componencheck',
        'name_componencheck',
    ];
    public function getcomponenproperty()
    {
        return $this->hasMany(Machineresult::class);
    }
}
