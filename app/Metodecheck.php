<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metodecheck extends Model
{
    protected $fillable = [
        'id_parameter',
        'name_metodecheck'
    ];
    public function getparentmetode()
    {
        return $this->hasMany(Parameter::class);
    }
    public function getchildernrecords()
    {
        return $this->belongsTo(Machinerecord::class);
    }
}
