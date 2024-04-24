<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Importdata;
use Maatwebsite\Excel\Facades\Excel;

class ImportdataController extends Controller
{
    public function indextableimport()
    {
        $machines = DB::table('machines')
        ->select('machines.*', 'componenchecks.*', 'parameters.*', 'metodechecks.*')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->orderBy('machines.id', 'asc')
        ->get();

        return view('dashboard.view_importdata.tableimportdata',[
            'machines' => $machines
        ]);
    }
    public function downloadExcel(Request $request, $type)
	{
		$data = Item::get()->toArray();
		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
	public function importexcel(Request $request)
	{
		if($request->hasFile('file')){
			$path = $request->file('file')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();
			if(!empty($data) && $data->count()){
				foreach ($data->toArray() as $key => $value) {
					if(!empty($value)){
						foreach ($value as $v) {		
							$insert[] = ['title' => $v['title'], 'description' => $v['description']];
						}
					}
				}
				if(!empty($insert)){
                    Excel::insert($insert);
					return back()->with('success','Insert Record successfully.');
				}
			}
		}
		return back()->with('error','Please Check your file, Something is wrong there.');
	}
    public function importdata(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $file = $request->file('file');
        try {
            Excel::import(new Importdata, $file->path());
            return redirect()->back()->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: '. $e->getMessage());
        }
    }
    
    
    // public function uploaddata(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $filename = date("Y-m-d H.i.s") . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('assets/uploads/'), $filename);

    //         // Import the data from the uploaded file
    //         Excel::import(new Importdata, public_path('assets/uploads/' . $filename));
    //         return response()->json(['success' => 'File uploaded successfully.']);
    //     } else {
    //         echo ('Please select a file!');
    //     }
    //     return response()->json(['error' => 'No file selected.']);
    // }
    // public function uploaddata(Request $request)
    // {
    //     if (!$request->hasFile('file')) {
    //         return response()->json(['error' => 'No file selected.']);
    //     }
    //     $file = $request->file('file');
    //     $filename = date("Y-m-d H.i.s") . '.' . $file->getClientOriginalExtension();
    //     $file->move(public_path('assets/uploads/'), $filename);
    //     try {
    //         // Import the data from the uploaded file
    //         Excel::import(new Importdata, public_path('assets/uploads/' . $filename));
    //         return response()->json(['success' => 'File uploaded successfully.']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error importing file: ' . $e->getMessage()]);
    //     }
    // }
}
