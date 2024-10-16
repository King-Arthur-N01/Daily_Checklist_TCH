<?php

namespace App;

use App\Http\Controllers\MachineScheduleMonthController;
use Illuminate\Database\Eloquent\Model;

class MonthlySchedule extends Model
{
    protected $fillable = [
        'name_schedule',
        'schedule_status',
        'id_schedule_year'
    ];

    public function machine_month_children()
    {
        return $this->belongsTo(MachineSchedule::class);
    }
}
