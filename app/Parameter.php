<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'id_componencheck',
        // 'componencheck_parameter',
        'name_parameter'
    ];
    public function getparentcomponen()
    {
        return $this->hasMany(Componencheck::class);
    }
    public function getchildernmetode()
    {
        return $this->belongsTo(Metodecheck::class);
    }
}
