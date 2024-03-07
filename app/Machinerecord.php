<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class Machinerecord extends Model
{
    protected $fillable = [
        'id_machinerecord',
        'action_check',
        'action_cleaning',
        'action_adjust',
        'action_replace',
        'shift',
        'result',
        'note'
    ];
    // public static function boot() {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->id = IdGenerator::generate(['table' => 'machinerecords', 'length' => 10, 'prefix' => 'USR-']);
    //     });
    // }
    public function getparentmachine()
    {
        return $this->hasMany(Machine::class);
    }
    public function getparentuser()
    {
        return $this->hasMany(User::class);
    }
}
