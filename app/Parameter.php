<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'id_parameter',
        'name_parameter'
    ];
    public function getparameterproperty()
    {
        return $this->hasMany(Machineresult::class);
    }
}
