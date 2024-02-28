<?php

namespace App;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;

class Machineresult extends Model
{
    protected $fillable = [
        'machine_coderesult',
        'id_componencheck1',
        'id_parameter1',
        'id_metodecheck1',
        'id_componencheck2',
        'id_parameter2',
        'id_metodecheck2',
        'id_componencheck3',
        'id_parameter3',
        'id_metodecheck3',
        'id_componencheck4',
        'id_parameter4',
        'id_metodecheck4',
        'id_componencheck5',
        'id_parameter5',
        'id_metodecheck5',
        'id_componencheck6',
        'id_parameter6',
        'id_metodecheck6',
        'id_componencheck7',
        'id_parameter7',
        'id_metodecheck7',
        'id_componencheck8',
        'id_parameter8',
        'id_metodecheck8',
        'id_componencheck9',
        'id_parameter9',
        'id_metodecheck9',
        'id_componencheck10',
        'id_parameter10',
        'id_metodecheck10',
        'id_componencheck11',
        'id_parameter11',
        'id_metodecheck11',
        'id_componencheck12',
        'id_parameter12',
        'id_metodecheck12'
    ];
    public function getmachineproperty() {
        return $this->belongsTo(Machine::class, 'machine_code');
    }
    public function getcomponenproperty(){
        return $this->belongsTo(Componencheck::class, 'id_componencheck');
    }
    public function getparameterproperty(){
        return $this->belongsTo(Parameter::class,'id_parameter');
    }
    public function getmetodeproperty(){
        return $this->belongsTo(Metodecheck::class,'id_metodecheck');
    }
}
