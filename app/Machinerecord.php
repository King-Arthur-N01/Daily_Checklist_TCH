<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Machinerecord extends Model
{
    protected $fillable = [
        'shift',
        'note',
        'create_by',
        'correct_by',
        'approve_by',
        'id_machine_schedule',
        'operator_action',
        'result',
        'machinerecord_status',
        'abnormal_record',
        'start_preventive',
        'finish_preventive',
        'record_date',
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
