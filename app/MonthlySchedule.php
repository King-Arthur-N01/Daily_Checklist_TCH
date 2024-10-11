<?php

namespace App;

use App\Http\Controllers\MachineScheduleMonthController;
use Illuminate\Database\Eloquent\Model;

class MonthlySchedule extends Model
{
    protected $fillable = [
        'name_schedule',
        'machine_collection',
        'schedule_status'
    ];

    public function machine_month_children()
    {
        return $this->belongsTo(MachineScheduleMonth::class);
    }
}
