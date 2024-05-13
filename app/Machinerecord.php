<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class Machinerecord extends Model
{
    protected $fillable = [
        'machine_number2',
        'shift',
        'note',
        'id_machine2',
        'reject_by',
        'create_by',
        'corrected_by',
        'approve_by',
        'record_time',
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
    public function getchildernhistoryrecord()
    {
        return $this->belongsTo(Historyrecords::class);
    }
}
