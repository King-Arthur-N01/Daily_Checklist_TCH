<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Machine;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachineController extends Controller
{
    public function notuseindexmachine()
    {
        $machines=Machine::get();
        return view ('dashboard.view_mesin.tablemachine',['machines'=>$machines]);
    }

    public function notuseregistermachine()
    {
        return view ('dashboard.view_mesin.addmachine');
    }

    public function notuseupdatemachine($id)
    {
        $machines=Machine::find($id);
        return view ('dashboard.view_mesin.editmachine',['machines'=>$machines]);
    }

    public function notusepushregistermachine(Request $request)
    {
        // $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();
        // if (isset($lastMachineCode)) {
        //     $currentvalue =  $lastMachineCode->machine_code + 1;
        // } else {
        //     $currentvalue = 1;
        // }
        $request->validate([
            'invent_number' => 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        //simpan data
        // $machines = Machine::create($request->all());
        //sembari update data nomor mesin
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        Machine::create($request->all());
        return redirect()->route("managemachine")->withSuccess('Machine added successfully.');
    }

    public function notusepushupdatemachine(Request $request, $id)
    {
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required|max:255',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date'
        ]);
        $machines = Machine::find($id);
        $machines->update($request->all());
        // $machines->machine_code = $currentvalue;
        // $machines->save();
        return redirect()->route("managemachine")->withSuccess('Machine updated successfully.');
    }

    // fungsi tambah mesin secara manual
    public function createmachine(Request $request)
    {
        $request->validate([
            'invent_number' => 'required',
            'machine_number'=> 'required',
            'machine_name' => 'required',
            'machine_brand',
            'machine_type',
            'machine_spec',
            'machine_made',
            'mfg_number' => 'required',
            'install_date',
        ]);
        try {
            Machine::create($request->all());
            return response()->json(['success' => 'Machine added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Machine failed to add!!!!']);
        }
    }

    public function updatemachine(Request $request, $id)
    {
        try {
            $currenttime = Carbon::today();
            $preventivetime = $request->input('schedule_time');
            // dd($request->input('schedule_time'));
            $nextpreventive = $currenttime->addMonths($preventivetime);
            $machineid = Schedule::where('id_machine2',$id)->first();
            if (!$machineid){
                $StoreMachines = Machine::find($id);
                $StoreMachines->invent_number = $request->input('invent_number');
                $StoreMachines->machine_number = $request->input('machine_number');
                $StoreMachines->machine_name = $request->input('machine_name');
                $StoreMachines->machine_brand = $request->input('machine_brand');
                $StoreMachines->machine_type = $request->input('machine_type');
                $StoreMachines->machine_spec = $request->input('machine_spec');
                $StoreMachines->machine_made = $request->input('machine_made');
                $StoreMachines->mfg_number = $request->input('mfg_number');
                $StoreMachines->install_date = $request->input('install_date');
                $StoreMachines->id_property = $request->input('id_property');
                $StoreMachines->save();

                $StoreSchedule = new Schedule;
                $StoreSchedule->id_machine2 = $id;
                $StoreSchedule->schedule_time = $request->input('schedule_time');
                $StoreSchedule->schedule_next = $nextpreventive;
                $StoreSchedule->save();
                return response()->json(['success' => 'Machine updated successfully.']);
            } else {
                $StoreMachines = Machine::find($id);
                $StoreMachines->invent_number = $request->input('invent_number');
                $StoreMachines->machine_number = $request->input('machine_number');
                $StoreMachines->machine_name = $request->input('machine_name');
                $StoreMachines->machine_brand = $request->input('machine_brand');
                $StoreMachines->machine_type = $request->input('machine_type');
                $StoreMachines->machine_spec = $request->input('machine_spec');
                $StoreMachines->machine_made = $request->input('machine_made');
                $StoreMachines->mfg_number = $request->input('mfg_number');
                $StoreMachines->install_date = $request->input('install_date');
                $StoreMachines->id_property = $request->input('id_property');
                $StoreMachines->save();

                $StoreSchedule = Schedule::find($id->id_machine2);
                $StoreSchedule->schedule_time = $request->input('schedule_time');
                $StoreSchedule->schedule_next = $nextpreventive;
                $StoreSchedule->save();
                return response()->json(['success' => 'Machine updated successfully.']);
            }
            // return response()->json(['success' => 'Machine updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to update machine: ' . $e->getMessage());
            return response()->json(['error' => 'Machine failed to update!!!!']);
        }
    }

    // fungsi hapus data mesin
    public function deletemachine($id) {
        $deletemachine = Machine::where('id', $id)->delete();

        if ($deletemachine > 0) {
            return response()->json(['success' => 'Data mesin berhasil dihapus!']);
        } else {
            return response()->json(['error' => 'Data mesin gagal dihapus.'], 422);
        }
    }
}
