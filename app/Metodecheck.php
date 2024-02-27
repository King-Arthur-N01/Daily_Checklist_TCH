<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metodecheck extends Model
{
    protected $fillable = [
        'id_metodecheck',
        'name_metodecheck',
    ];
    public function getmetoderoperty()
    {
        return $this->hasMany(Machineresult::class);
    }
}
