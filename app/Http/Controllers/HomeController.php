<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ScheduleData\YearlyScheduleController;
use App\MachineSchedule;
use App\MonthlySchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try{
            $yearnow = Carbon::now()->format('Y');

            $scheduledata = MachineSchedule::all();

            // dd($yearlydata);

            return view('dashboard.home', compact('scheduledata'));
        } catch (\Exception $e) {
            Log::error(' fetch data error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
}
