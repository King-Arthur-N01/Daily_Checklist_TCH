<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class Machinerecord extends Model
{
    protected $fillable = [
        'shift',
        'note',
        'machine_number2',
        'create_by',
        'correct_by',
        'approve_by',
        'id_machineschedule',
        'operator_action',
        'result',
        'machinerecord_status',
        'abnormal_record',
        'start_preventive',
        'finish_preventive',
    ];
    // public static function boot()
    // {
    //     parent::boot();
    //     self::creating(function ($customid) {
    //         $customid->uuid = IdGenerator::generate(['table' => 'machinerecords', 'length' => 6, 'prefix' =>date('y')]);
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
    // public function getchildernhistoryrecord()
    // {
    //     return $this->belongsTo(Historyrecords::class);
    // }
}
