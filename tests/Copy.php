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
