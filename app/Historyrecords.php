<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historyrecords extends Model
{
    protected $fillable = [
    'id_metodecheck',
    'operator_action',
    'result',
    'id_machinerecord'
    ];

    public function getparentmachinerecord()
    {
        return $this->hasMany(Machinerecord::class);
    }
    public function getchildrenmetode()
    {
        return $this->belongsTo(Metodecheck::class);
    }
}
