<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function indextablehistory()
    {
        return view('dashboard.view_history.tablehistory');
    }
}
