<?php

namespace App;

use App\Http\Controllers\MachineScheduleMonthController;
use Illuminate\Database\Eloquent\Model;

class MonthlySchedule extends Model
{
    protected $fillable = [
        'name_schedule_month',
        'schedule_collection',
        'schedule_status',
        'schedule_special',
        'schedule_create',
        'schedule_recognize,',
        'schedule_agreed',
        'schedule_planner',
        'id_schedule_year'
    ];

    public function machine_month_children()
    {
        return $this->belongsTo(MachineSchedule::class);
    }
}
