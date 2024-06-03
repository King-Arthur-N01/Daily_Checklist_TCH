<?php

namespace App\Imports;

use App\Machine;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
class Importdata implements ToModel
{
    public function model(array $row)
    {
        Log::info('Importing row: ', $row);
        try {
            return new Machine([
                'invent_number'  => $row[1],
                'machine_number' => (int) $row[2],
                'machine_name'   => $row[3],
                'machine_brand'  => $row[4],
                'machine_type'   => $row[5],
                'machine_spec'   => $row[6],
                'machine_made'   => $row[7],
                'mfg_number'     => $row[8],
                'install_date'   => $row[9]
            ]);
        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            return null;
        }
    }
    // public function model(array $row)
    // {
    //     Log::info('Row keys: ' . implode(', ', array_keys($row)));

    //     if (!isset($row['Number'])) {
    //         Log::error('Undefined index: Number', ['row' => $row]);
    //         return null;
    //     }

    //     $datarow = $row['Number'];

    //     $data = [
    //         'invent_number' => $row['Invent Number'],
    //         'machine_name'   => $row['Machine Number'],
    //         'machine_brand'  => $row['Machine Brand'],
    //         'machine_type'   => $row['Machine Type'],
    //         'machine_spec'   => $row['Machine Spec'],
    //         'machine_made'   => $row['Machine Made'],
    //         'mfg_number'     => $row['MFG Number'],
    //         'install_date'   => $row['Install Date']
    //     ];

    //     Machine::updateOrCreate(['invent_number' => $datarow], $data);
    //     return Machine::where('invent_number', $datarow)->first();
    // }
    // public function model(array $row)
    // {
    //     // Check if 'Invent Number' key exists
    //     if (!isset($row['Invent Number'])) {
    //         Log::error('Error importing row: Undefined index: Invent Number');
    //         return null;
    //     }

    //     // Import data into the model
    //     return new Machine([
    //         'invent_number'  => $row['Invent Number'],
    //         'machine_number' => $row['Machine Number'],
    //         'machine_name'   => $row['Machine Name'],
    //         'machine_brand'  => $row['Machine Brand'],
    //         'machine_type'   => $row['Machine Type'],
    //         'machine_spec'   => $row['Machine Spec'],
    //         'machine_made'   => $row['Machine Made'],
    //         'mfg_number'     => $row['MFG Number'],
    //         'install_date'   => $row['Install Date']
    //     ]);
    // }
}
