<?php

namespace App;

use App\Machine;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
class Importdata implements ToModel
{
    private $isFirstRow = true;

    public function model(array $row)
    {
        if ($this->isFirstRow) {
            $this->isFirstRow = false;
            return null; // Skip the header row
        }

        try {
            // Check if invent_number already exists in the database
            $existingMachine = Machine::where('invent_number', $row[1])->first();

            if ($existingMachine) {
                $errorMessage = 'Duplicate invent_number: ' . $row[1];
                Log::error($errorMessage);

                return response()->json(['error' => $errorMessage], 422);
            }

            return new Machine([
                'invent_number'  => $row[1],
                'machine_number' => $row[2],
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
}
