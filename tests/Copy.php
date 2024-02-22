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





public function registermachine(Request $request)
{
    $request->validate([
        'invent_number' => 'required',
        'machine_name' => 'required | max: 255',
        'machine_brand' => 'required',
        'machine_type' => 'required',
        'machine_spec' => 'required',
        'machine_made' => 'required',
        'mfg_number' => 'required',
        'install_date' => 'required',
    ]);

    // Generate machine code as auto-incrementing value
    $machineCode = 'MC-' . str_pad(Machine::count() + 1, 4, '0', STR_PAD_LEFT);

    Machine::create([
        'machine_code' => $machineCode,
        'invent_number' => $request->input('invent_number'),
        'machine_name' => $request->input('machine_name'),
        'machine_brand' => $request->input('machine_brand'),
        'machine_type' => $request->input('machine_type'),
        'machine_spec' => $request->input('machine_spec'),
        'machine_made' => $request->input('machine_made'),
        'mfg_number' => $request->input('mfg_number'),
        'install_date' => $request->input('install_date'),
    ]);

    return redirect()->route("tablemach



    Missing required parameters for [Route: pusheditmachine] [URI: editmachine/{id}]. (View: C:\laragon\www\Daily_Checklist_TCH\resources\views\dashboard\editmachine.blade.php)


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
