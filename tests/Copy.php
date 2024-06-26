<?php

$myarray = Array ( 'F' ,'F' ,'N' , 'l');

$j =0;

for($x = 0; $x < 2; $x++ ){
  echo $myarray[$x].'-'.$j.$x;
echo "<br>";
}
echo "<br>";


$m=0;
for($k=2;$k<=3;$k++){
  echo $myarray[$k].'-'.$j.$m;
    echo "<br>";
}


// Function to perform custom incrementation
function customIncrement(&$value, $incrementBy = 1) {
    $value += $incrementBy;
}

// Example usage
$counter = 0;
customIncrement($counter); // Increment by default value (1)
echo "Counter: $counter\n"; // Output: Counter: 1

public function registermachine(Request $request)
{
    // Get the last machine code from the database
    $lastMachineCode = Machine::orderBy('machine_code', 'desc')->first();

    // If there are no machines yet, set the machine code to 1
    if (!$lastMachineCode) {
        $currentvalue = 1;
    } else {
        // Otherwise, extract the number from the machine code and increment it
        preg_match('/\d+/', $lastMachineCode->machine_code, $matches);
        $currentvalue = intval($matches[0]) + 1;
    }

    $request->validate([
        'machine_code' => $currentvalue,
        'invent_number' => 'required',
        'machine_name' => 'required|max:255',
        'machine_brand',
        'machine_type',
        'machine_spec',
        'machine_made',
        'mfg_number' => 'required',
        'install_date'
    ]);

    Machine::create($request->all());

    return redirect()->route("tablemachine")->withSuccess('Machine added successfully.');
}


    <select name="owner">
    <option value=""></option>
    <?php (foreach $data as $row): ?>
    <option value="<?= htmlspecialchars($row['id']) ?>">
      <?= htmlspecialchars($row['username']) ?>
    </option>
    <?php endforeach ?>
  </select>


  // Di dalam controller
public function index()
{
    // Ambil data dari database
    $data = Model::all();

    // Filter data yang tidak kosong
    $filteredData = $data->reject(function ($item) {
        return empty($item->field);
    });

    return view('view_name', ['data' => $filteredData]);
}


public function indextablemachineresult()
{
    $emptyfield = Machineresult::all();
    // dd($emptyfield);
    // $filltertable = $emptyfield -> reject(function($emptydata){
    //     return empty($emptydata->field);
    // });
    // $filltertable=Machineresult::get();
    return view ('dashboard.view_hasilmesin.tablemesinresult',['machineresults'=> $emptyfield]);
}


public function indexregistermachineresult()
{
    $componenchecks = Componencheck::pluck('name_componencheck', 'id');
    $parameters = Parameter::pluck('name_parameter', 'id');
    $metodechecks = Metodecheck::pluck('name_metodecheck', 'id');

    return view('dashboard.view_hasilmesin.addmesinresult', [
        'componenchecks' => $componenchecks,
        'parameters' => $parameters,
        'metodechecks' => $metodechecks,
    ]);
}

<select name="id_componencheck1" id="id_componencheck1">
    @foreach ($componenchecks as $componencheck)
        <option value="{{ $componencheck->id }}" {{ old('id_componencheck1', $machineresult->componencheck_id ?? '') == $componencheck->id ? 'selected' : '' }}>
            {{ $componencheck->name }}
        </option>
    @endforeach
</select>

<select name="id_parameter1" id="id_parameter1">
    @foreach ($parameters as $parameter)
        <option value="{{ $parameter->id }}" {{ old('id_parameter1', $machineresult->parameter_id ?? '') == $parameter->id ? 'selected' : '' }}>
            {{ $parameter->name }}
        </option>
    @endforeach
</select>

<select name="id_metodecheck1" id="id_metodecheck1">
    @foreach ($metodechecks as $metodecheck)
        <option value="{{ $metodecheck->id }}" {{ old('id_metodecheck1', $machineresult->metodecheck_id ?? '') == $metodecheck->id ? 'selected' : '' }}>
            {{ $metodecheck->name }}
        </option>
    @endforeach
</select>



php artisan migrate:refresh -path=\database\migrations\22_03_18_010_create_users_table.php



public function indextablemachineresult()
{
    $machines = Machine::all();
    $componenchecks = Componencheck::all();
    $parameters = Parameter::all();
    $metodechecks = Metodecheck::all();
    $machineresults = Machineresult::all();

    return view('dashboard.view_hasilmesin.tablemesinresult', [
        'machines' => $machines,
        'componenchecks' => $componenchecks,
        'parameters' => $parameters,
        'metodechecks' => $metodechecks,
        'machineresults' => $machineresults
    ]);
}


use Illuminate\Support\Facades\DB;

// Assuming you have defined the relationships between models (e.g., Machine, Componencheck, Parameter) in your Eloquent models

// Retrieve the data using joins
$joinedData = DB::table('machineresults')
    ->join('machines', 'machineresults.machine_id', '=', 'machines.id')
    ->join('componenchecks', 'machineresults.componencheck_id', '=', 'componenchecks.id')
    ->join('parameters', 'machineresults.parameter_id', '=', 'parameters.id')
    ->select(
        'machineresults.*', // Select all columns from machineresults
        'machines.name as machine_name', // Alias for machine name
        'componenchecks.name as component_name', // Alias for component name
        'parameters.name as parameter_name' // Alias for parameter name
    )
    ->get();

// Now you can access the joined data
foreach ($joinedData as $data) {
    echo "Machine Result ID: {$data->id}\n";
    echo "Machine Name: {$data->machine_name}\n";
    echo "Component Name: {$data->component_name}\n";
    echo "Parameter Name: {$data->parameter_name}\n";
    // Add other relevant fields as needed
    echo "\n";
}


public function index()
{
    $machineresults = MachineResult::with(['machine', 'componencheck', 'parameter', 'metodecheck'])->get();
    return view('dashboard.view_hasilmesin.tablemesinresult', ['machineresults' => $machineresults]);
}



SELECT machineresults.*, componenchecks.*, parameters.*, metodechecks.*
FROM machineresults
JOIN machines ON machineresults.machine_coderesult = machines.machine_code
JOIN componenchecks ON machineresults.id_componencheck1 = componenchecks.id_componencheck OR machineresults.id_componencheck2 = componenchecks.id_componencheck OR machineresults.id_componencheck3 = componenchecks.id_componencheck OR machineresults.id_componencheck4 = componenchecks.id_componencheck OR machineresults.id_componencheck5 = componenchecks.id_componencheck OR machineresults.id_componencheck6 = componenchecks.id_componencheck OR machineresults.id_componencheck7 = componenchecks.id_componencheck OR machineresults.id_componencheck8 = componenchecks.id_componencheck OR machineresults.id_componencheck9 = componenchecks.id_componencheck OR machineresults.id_componencheck10 = componenchecks.id_componencheck OR machineresults.id_componencheck11 = componenchecks.id_componencheck OR machineresults.id_componencheck12 = componenchecks.id_componencheck
JOIN parameters ON machineresults.id_parameter1 = parameters.id_parameter OR machineresults.id_parameter2 = parameters.id_parameter OR machineresults.id_parameter3 = parameters.id_parameter OR machineresults.id_parameter4 = parameters.id_parameter OR machineresults.id_parameter5 = parameters.id_parameter OR machineresults.id_parameter6 = parameters.id_parameter OR machineresults.id_parameter7 = parameters.id_parameter OR machineresults.id_parameter8 = parameters.id_parameter OR machineresults.id_parameter9 = parameters.id_parameter OR machineresults.id_parameter10 = parameters.id_parameter OR machineresults.id_parameter11 = parameters.id_parameter OR machineresults.id_parameter12 = parameters.id_parameter
JOIN metodechecks ON machineresults.id_metodecheck1 = metodechecks.id_metodecheck OR machineresults.id_metodecheck2 = metodechecks.id_metodecheck OR machineresults.id_metodecheck3 = metodechecks.id_metodecheck OR machineresults.id_metodecheck4 = metodechecks.id_metodecheck OR machineresults.id_metodecheck5 = metodechecks.id_metodecheck OR machineresults.id_metodecheck6 = metodechecks.id_metodecheck OR machineresults.id_metodecheck7 = metodechecks.id_metodecheck OR machineresults.id_metodecheck8 = metodechecks.id_metodecheck OR machineresults.id_metodecheck9 = metodechecks.id_metodecheck OR machineresults.id_metodecheck10 = metodechecks.id_metodecheck OR machineresults.id_metodecheck11 = metodechecks.id_metodecheck OR machineresults.id_metodecheck12 = metodechecks.id_metodecheck;




SELECT
    machineresults.*, componenchecks.*, parameters.*, metodechecks.*
FROM
    machineresults
JOIN
    machines ON machineresults.machine_coderesult = machines.machine_code
LEFT JOIN
    (
        SELECT
            id_componencheck, id_parameter, id_metodecheck
        FROM
            componenchecks
    ) componenchecks ON machineresults.id_componencheck1 = componenchecks.id_componencheck
        OR machineresults.id_componencheck2 = componenchecks.id_componencheck
        OR machineresults.id_componencheck3 = componenchecks.id_componencheck
        OR machineresults.id_componencheck4 = componenchecks.id_componencheck
        OR machineresults.id_componencheck5 = componenchecks.id_componencheck
        OR machineresults.id_componencheck6 = componenchecks.id_componencheck
        OR machineresults.id_componencheck7 = componenchecks.id_componencheck
        OR machineresults.id_componencheck8 = componenchecks.id_componencheck
        OR machineresults.id_componencheck9 = componenchecks.id_componencheck
        OR machineresults.id_componencheck10 = componenchecks.id_componencheck
        OR machineresults.id_componencheck11 = componenchecks.id_componencheck
        OR machineresults.id_componencheck12 = componenchecks.id_componencheck
LEFT JOIN
    (
        SELECT
            id_parameter
        FROM
            parameters
    ) parameters ON machineresults.id_parameter1 = parameters.id_parameter
        OR machineresults.id_parameter2 = parameters.id_parameter
        OR machineresults.id_parameter3 = parameters.id_parameter
        OR machineresults.id_parameter4 = parameters.id_parameter
        OR machineresults.id_parameter5 = parameters.id_parameter
        OR machineresults.id_parameter6 = parameters.id_parameter
        OR machineresults.id_parameter7 = parameters.id_parameter
        OR machineresults.id_parameter8 = parameters.id_parameter
        OR machineresults.id_parameter9 = parameters.id_parameter
        OR machineresults.id_parameter10 = parameters.id_parameter
        OR machineresults.id_parameter11 = parameters.id_parameter
        OR machineresults.id_parameter12 = parameters.id_parameter
LEFT JOIN
    (
        SELECT
            id_metodecheck
        FROM
            metodechecks
    ) metodechecks ON machineresults.id_metodecheck1 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck2 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck3 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck4 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck5 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck6 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck7 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck8 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck9 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck10 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck11 = metodecheck.id_metodecheck
        OR machineresults.id_metodecheck12 = metodecheck.id_metodecheck;



        SELECT machineresults.*, componenchecks.*, parameters.*, metodechecks.*
        FROM machineresults
        JOIN machines ON machineresults.machine_coderesult = machines.machine_name
        JOIN componenchecks ON machineresults.id_componencheck1 = componenchecks.name_componencheck
        OR machineresults.id_componencheck2 = componenchecks.name_componencheck
        OR machineresults.id_componencheck3 = componenchecks.name_componencheck
        OR machineresults.id_componencheck4 = componenchecks.name_componencheck
        OR machineresults.id_componencheck5 = componenchecks.name_componencheck
        OR machineresults.id_componencheck6 = componenchecks.name_componencheck
        OR machineresults.id_componencheck7 = componenchecks.name_componencheck
        OR machineresults.id_componencheck8 = componenchecks.name_componencheck
        OR machineresults.id_componencheck9 = componenchecks.name_componencheck
        OR machineresults.id_componencheck10 = componenchecks.name_componencheck
        OR machineresults.id_componencheck11 = componenchecks.name_componencheck
        OR machineresults.id_componencheck12 = componenchecks.name_componencheck

        JOIN parameters ON machineresults.id_parameter1 = parameters.name_parameter
        OR machineresults.id_parameter2 = parameters.name_parameter
        OR machineresults.id_parameter3 = parameters.name_parameter
        OR machineresults.id_parameter4 = parameters.name_parameter
        OR machineresults.id_parameter5 = parameters.name_parameter
        OR machineresults.id_parameter6 = parameters.name_parameter
        OR machineresults.id_parameter7 = parameters.name_parameter
        OR machineresults.id_parameter8 = parameters.name_parameter
        OR machineresults.id_parameter9 = parameters.name_parameter
        OR machineresults.id_parameter10 = parameters.name_parameter
        OR machineresults.id_parameter11 = parameters.name_parameter
        OR machineresults.id_parameter12 = parameters.name_parameter

        JOIN metodechecks ON machineresults.id_metodecheck1 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck2 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck3 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck4 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck5 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck6 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck7 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck8 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck9 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck10 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck11 = metodechecks.name_metodecheck
        OR machineresults.id_metodecheck12 = metodechecks.name_metodecheck;


        SELECT machines.*, componenchecks.*, parameters.*, metodechecks.*
        FROM machines
        JOIN componenchecks ON machines.id = componenchecks.id_machine
        JOIN parameters ON componenchecks.id = parameters.id_componencheck
        JOIN metodechecks ON parameters.id = metodechecks.id_parameter
        WHERE machines.id = 1;

        @if($componencheckget->machine_code_componencheck == $componencheckget->machine_code) selected="selected" @endif


        <td>{{$machineget->machine_name}}</td>
        <td>{{$machineget->name_componencheck}}</td>
        <td>{{$machineget->name_parameter}}</td>

        for($totmachinecheck=0; $totmachinecheck<=$totalchecks; $totmachinecheck++){
        }


        <select>
            <option type="radio" name="action_check" value="check">CHECK</option>
            <br>
            <option type="radio" name="action_cleaning" value="clean">CLEAN</option>
            <br>
            <option type="radio" name="action_adjust" value="adjust">ADJUST</option>
            <br>
            <option type="radio" name="action_replace" value="replace">REPLACE</option>
            <br>
        </select>


        $dataToInsert = [];

            foreach ($Kanban_no as $key => $kanban) {
                $dataToInsert[] = [
                    'kanban_no' => $kanban,
                    'chuter_address' => $chutterAddres,
                    'seq' => $squences[$key],
                    'in_datetime' => $in_date,
                    'created_by' => $created_by
                ];
            }
            // dd($dataToInsert);
            // Melakukan insert untuk semua data sekaligus
            chuter_in_out_log::insert($dataToInsert);


SELECT machinerecords.*, machines.*, componenchecks.*, parameters.*, metodechecks.*
FROM machinerecords
JOIN machines ON machinerecords.id_machinerecord = machines.id
JOIN componenchecks ON machines.id = componenchecks.id_machine
JOIN parameters ON componenchecks.id = parameters.id_componencheck
JOIN metodechecks ON parameters.id = metodechecks.id_parameter
WHERE machinerecords.id_machinerecord = 1


@foreach ($historyrecords as $index => $record)
    <tr>
        <td>{{ $splitrecords->machine_name }}</td>
        <td>{{ $splitrecords->name_componencheck }}</td>
        <td>{{ $splitrecords->name_parameter }}</td>
        <td>{{ $splitrecords->name_metodecheck }}</td>
    <!-- Display the operator_action array as separate rows -->
    @foreach ($operator_action[$index] as $operator)
        <td>{{ $operator }}</td>
    @endforeach

    <!-- Display the result array as separate rows -->
    @foreach ($result[$index] as $resultItem)
        <td>{{ $resultItem }}</td>
    @endforeach
    </tr>
@endforeach



public function registermachinerecord(Request $request)
    {
        $operatoraction = $request->input('operator_action', []);
        $result = $request->input('result', []);
        $get_machineid = Machine::where('id', $request->id)->first();
        $get_machineid = Machine::select('id')->get();
        $getuserid = Auth()->user()->id;

        $storeInfo = new Machinerecord();
        $storeInfo->operator_action = implode(',', $operatoraction);
        $storeInfo->result = implode(',', $result);
        $storeInfo->note= $request->input('note');
        $storeInfo->machine_number= $request->input('machine_number');
        $storeInfo->id_machinerecord= $request->input('id_machinerecord');
        $storeInfo -> id_user = $getuserid;
        dd($storeInfo);
        $storeInfo -> id_machinerecord = $get_machineid;
        $storeInfo->save();
        return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
    }







    $myUserId = 3;
    $shares = Share::with('user')
    ->join('follows', 'follows.user_id', '=', 'shares.user_id')
    ->where('follows.follower_id', '=', $myUserId)
    ->get(['shares.*']);

    // Print the username of the person who shared something
    foreach ($shares as $share) {
        echo $share->user->username;
    }


    public function viewdetails($id)
    {
        $historyrecords = DB::table('machinerecords')
        ->select('machinerecords.*', 'machines.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck')
        ->join('machines', 'machinerecords.id_machinerecord', '=', 'machines.id')
        ->join('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
        ->join('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
        ->join('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
        ->where('machinerecords.id', '=', $id)
        ->get();

        $operator_action = [];
        foreach ($historyrecords as $getoperator) {
            $operator_action[] = preg_split('/\s*,\s*/', $getoperator->operator_action);
        }
        $result = [];
        foreach ($historyrecords as $getresult) {
            $result[] = preg_split('/\s*,\s*/', c$getresult->result);
        }
        return view ('dashboard.view_history.detailspreventive',[
            'historyrecords' => $historyrecords,
            'operator_action' => $operator_action,
            'result' => $result
        ]);
    }


    public function import(Request $request)
    {
        // validasi file yang diupload
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // menyimpan file yang diupload ke folder publik
        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        'public';
        $file->storeAs('storage', $nama_file);
        // baca isi file csv menggunakan fungsirfputcvs
        $rows = array_map('str_getcsv', file('storage/' . $nama_file));
        $header = $rows[0];
        $databarang = [];
        foreach ($rows as $row) {
            if (count($row)) {
                $databarang[] = array_combine($header, $row);
            }
        }
        // menghapus file csv dari folder publik
        unlink(public_path('/storage/') . $nama_file);
        return view('dashboard.view_hasilmesin.forminputmesin', compact(['databarang']));
    }



$(document).ready(function() {
    $('#uploadForm').submit(function(e) {
        e.preventDefault(); // Prevent normal form submission
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '{{ route("upload.file") }}', // Route to handle file upload
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#message').html(response); // Display response message
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});


$(".btn-show").on('click', function() {
    console.log($(this).attr("data-id"));
    $("#rejectButton").attr("value",$(this).attr("data-id"));
    $("#saveButton").attr("value",$(this).attr("data-id"));
});


$('#historyTables tr').each(function() {
    var correctCell = $(this).find('td:eq(4)');
    var approveCell = $(this).find('td:eq(5)');
    var rejectCell = $(this).find('td:eq(6)');
    var correct = correctCell.text().trim();
    var approve = approveCell.text().trim();
    var reject = rejectCell.text().trim();
    if (correct === '') {
        correctCell.text('BELUM DI KOREKSI');
    } else if (correct !== '') {
        approveCell.text('SUDAH DI KOREKSI');
    } else if (approve === '') {
        approveCell.text('BELUM DI SETUJUI');
    } else if (approve !== '') {
        approveCell.text('SUDAH DI SETUJUI');
    } else if (reject !== '') {
        rejectCell.text('SUDAH DI REJECT')
    }
});



public function fetchdataapproval($id) // this code for ajax modal html
    {
        $machinedata = DB::table('machinerecords')
            ->select('machinerecords.*', 'machines.*', 'componenchecks.name_componencheck', 'parameters.name_parameter', 'metodechecks.name_metodecheck', 'metodechecks.id as checks_id')
            ->leftJoin('machines', 'machinerecords.id_machine2', '=', 'machines.id')
            ->leftJoin('componenchecks', 'machines.id', '=', 'componenchecks.id_machine')
            ->leftJoin('parameters', 'componenchecks.id', '=', 'parameters.id_componencheck')
            ->leftJoin('metodechecks', 'parameters.id', '=', 'metodechecks.id_parameter')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $recordsdata = DB::table('machinerecords')
            ->select('machinerecords.*', 'historyrecords.*', 'users.*', 'machinerecords.id as get_id', 'historyrecords.id_metodecheck as get_checks')
            ->leftJoin('historyrecords', 'machinerecords.id', '=', 'historyrecords.id_machinerecord')
            ->leftJoin('users', 'machinerecords.create_by', '=' ,'users.id')
            ->where('machinerecords.id', '=', $id)
            ->get('machinerecords.id');

        $combinedata = [];
        foreach ($machinedata as $getmachine){
            foreach ($recordsdata as $getrecords){
                if ($getmachine->checks_id == $getrecords->get_checks){
                    $combinedata[] = [
                        'machine_name' => $getmachine->machine_name,
                        'name_componencheck' => $getmachine->name_componencheck,
                        'name_parameter' => $getmachine->name_parameter,
                        'name_metodecheck' => $getmachine->name_metodecheck,
                        'operator_action' => $getrecords->operator_action,
                        'result' => $getrecords->result,
                    ];
                }
            }
        }
        return response()->json([
        'machinedata' => $machinedata,
        'recordsdata' => $recordsdata,
        'combinedata' => $combinedata
        ]);
    }

    <table class="table table-bordered">
    <tr>
        <th>No. Invent Mesin :</th>
        <td>{{ $machinedata[0].invent_number }}</td>
        <th>Spec/Tonage :</th>
        <td>{{ $machinedata[0].machine_spec }}</td>
    </tr>
    <tr>
        <th>Nama Mesin :</th>
        <td>{{ $machinedata[0].machine_name }}</td>
        <th>Buatan :</th>
        <td>{{ $machinedata[0].machine_made }}</td>
    </tr>
    <tr>
        <th>Brand/Merk :</th>
        <td>{{ $machinedata[0].machine_brand }}</td>
        <th>Mfg.NO :</th>
        <td>{{ $machinedata[0].mfg_number }}</td>
    </tr>
    <tr>
        <th>Model/Type :</th>
        <td>{{ $machinedata[0].machine_type }}</td>
        <th>Install Date :</th>
        <td>{{ $machinedata[0].install_date }}</td>
    </tr>
</table>
<h4>History Records</h4>
<table class="table table-bordered" id="dataTables">
    <thead>
        <tr>
            <th>Nama Mesin</th>
            <th>Bagian Yang Dicheck</th>
            <th>Standart/Parameter</th>
            <th>Metode Pengecekan</th>
            <th>Action</th>
            <th>Result</th>
        </tr>
    </thead>
    <tbody>
        {{#each $combinedata}}
        <tr>
            <td>{{machine_name}}</td>
            <td>{{name_componencheck}}</td>
            <td>{{name_parameter}}</td>
            <td>{{name_metodecheck}}</td>
            <td>{{operator_action}}</td>
            <td>{{result}}</td>
        </tr>
        {{/each}}
    </tbody>
</table>
<div class="form-custom">
    <label for="input_note" class="col-form-label text-sm-left" style="margin-left: 4px;">Keterangan</label>
    <textarea id="input_note" type="text" rows="6" cols="50" readonly>{{ $machinedata[0].note }}</textarea>
</div>
<div class="form-custom">
    <table class="table table-bordered" id="userTable">
        <thead>
            <tr>
                <th>Direject oleh :</th>
                <th>Disetujui oleh :</th>
                <th>Dikoreksi oleh :</th>
                <th>Dibuat oleh :</th>
            </tr>
            <tr>
                <td>{{ $recordsdata[0].modify_by }}</td>
                <td>{{ $recordsdata[0].approve_by }}</td>
                <td>{{ $recordsdata[0].correct_by }}</td>
                <td>{{ $recordsdata[0].create_by }}</td>
            </tr>
        </thead>
    </table>
</div>



$('#rejectButton').on('click', function() {
    if (!confirmReject()) {
        return;
    }
    var machineId = $(this).val(); // Get the machine ID from the button that triggered the modal
    var rejectBy = '{{ Auth::user()->id }}';
    $.ajax({
        type: 'PUT',
        url: '{{ route('pushreject1', ':id') }}'.replace(':id', machineId),
        data: {
            '_token': '{{ csrf_token() }}', // Include the CSRF token
            'reject_by': rejectBy
        },
        success: function(response) {
            if (response.success) {
                const successMessage = response.success;
                $('#successText').text(successMessage);
                $('#successModal').modal('show'); // Show success modal
            } else {
                $('#failedModal').modal('show'); // Show failed modal
            }
            $('#ExtralargeModal').modal('hide'); // Hide modal on success
        },
        error: function(xhr, status, error) {
            var warningMessage = xhr.responseText;
            try {
                warningMessage = JSON.parse(xhr.responseText).error;
            } catch (e) {
                console.error('Error parsing error message:', e);
            }
            $('#warningText').text(warningMessage); // Set the error message in the modal
            $('#warningModal').modal('show'); // Show error modal
            console.error('Error saving machine record: ' + error);
            $('#ExtralargeModal').modal('hide'); // Hide modal on error
        }
    }).always(function() {
        setTimeout(function() {
            location.reload(); // Refresh the page after a 2-second delay
        }, 2000); // 2000 milliseconds = 2 seconds
    });
});


public function importdata(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        dd($request->file('file'));
        try {
            Excel::import(new Machine, $request->file('file'));
            return response()->json(['success' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data Preventive FAILED to be upload !!!!']);
        }
    }

    // <<<============================================================================================>>>
    // <<<================================batas import data controller================================>>>
    // <<<============================================================================================>>>

    public function import_excel(REQUEST $request){
        //check izin yang bisa mengakses
        $check_permission = CustomHelper::check_role("staff",session('role'));
        if(!$check_permission){
            return redirect()->back();
        }
        $base64Data = $request->input('import_excel'); // Ambil data Base64 dari permintaan
        //cek kevalitan base 64
        if ($base64Data) {
            // Dekode data Base64 menjadi bentuk biner
            $decodedData = base64_decode($base64Data);
            // Buat temporary file untuk menyimpan data Excel yang didekode
            $tempFile = tempnam(sys_get_temp_dir(), 'decoded_excel');
            file_put_contents($tempFile, $decodedData);
            // Impor data dari file Excel menggunakan Laravel Excel
            $import = new MasterPartImports();
            Excel::import($import, $tempFile);
            // Hapus temporary file
            unlink($tempFile);
            return response()->json(['message' => 'Data berhasil diimpor ke database.']);
        }
        return response()->json(['message' => 'Data Base64 tidak ditemukan atau tidak valid.'], 400);
    }
    // <<<============================================================================================>>>
    // <<<================================batas import controller end=================================>>>
    // <<<============================================================================================>>>





    // <<<============================================================================================>>>
    // <<<==================================batas import data models==================================>>>
    // <<<============================================================================================>>>

    class MasterPartImports implements ToModel
    {
        public function model(array $row)
        {
            $partNumber = $row[0];

            $data = [
                'line_name' => $row[1],
                'line_group' => $row[2],
                'net_amount' => $row[3],
                'ct_second' => $row[4],
                'member_out_line' => $row[5],
            ];

            MasterPart::updateOrCreate(['part_number' => $partNumber], $data);

            // Jika Anda ingin mengembalikan model, Anda bisa gunakan ini
            return MasterPart::where('part_number', $partNumber)->first();
        }
    }
    // <<<============================================================================================>>>
    // <<<==================================batas import data models==================================>>>
    // <<<============================================================================================>>>

        $('#uploadButton').on('click', function (e) {
                var fileInput = document.getElementById("importExcel");
                var file = fileInput.files[0];
                var formData = new FormData();
                formData.append('file', file);
                
                $.ajax({
                    type: 'POST',
                    url: '{{ route('uploadfile') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            const successMessage = response.success;
                            $('#successText').text(successMessage);
                            $('#successModal').modal('show');
                        }
                        $('#ExtralargeModal').modal('hide');
                    },
                    error: function (status, error, response) {
                        if (response.error) {
                            const warningMessage = response.error;
                            $('#failedext').text(warningMessage);
                            $('#failedModal').modal('show');
                        }
                        $('#ExtralargeModal').modal('hide');
                    }
                });
            });
        });


        <script>
        $(document).ready(function () {
            const filterButton = document.getElementById("filterButton");
            const filterCard = document.getElementById("filterCard");

            filterButton.addEventListener("click", () => {
                if (filterCard.style.display === "none") {
                    $(filterCard).fadeIn(1000);
                    filterCard.style.display = "block";
                } else {
                    $(filterCard).fadeOut(1000);
                    filterCard.style.display = "none";
                }
            });
            $('#uploadButton').on('click', function (e) {
                var fileInput = document.getElementById("importExcel");
                var file = fileInput.files[0];
                var formData = new FormData();

                if (file) {
                    formData.append('importExcel', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('uploadfile') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                const successMessage = response.success;
                                $('#successText').text(successMessage);
                                $('#successModal').modal('show');
                            }
                            $('#ExtralargeModal').modal('hide');
                        },
                        error: function (xhr, status, error) {
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                const warningMessage = xhr.responseJSON.error;
                                $('#failedText').text(warningMessage);
                                $('#failedModal').modal('show');
                            }
                            $('#ExtralargeModal').modal('hide');
                        }
                    });
                }
            });
        });
    </script>


                <div class="card-filter" id="filterCard" style="display: none;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                    </div>
                    <form action="#" method="post" style="margin-top: 10px">
                        @csrf
                        <div class="table-filter">
                            <div class="dataTables_filter col-4" id="dataTable_filter">
                                <p class="mg-b-10">Input Nama Mesin</p>
                                <input class="form-control" id="searchInput" type="search" aria-controls="dataTable" placeholder="Search here"></input>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Nomor Mesin </p>
                                <select class="form-control select2" name="" id="category-input-machinecode">
                                    <option selected="selected" value="">Select :</option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p class="mg-b-10">Input Hari/Bulan/Tahun </p>
                                <div class="wd-250 mg-b-20">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="datetimepicker" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>