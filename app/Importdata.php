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
                $errorMessage = 'Duplicate NO.INVENT : ' . $row[1];
                Log::error($errorMessage);
                throw new \Exception($errorMessage);
            }

            return new Machine([
                'invent_number'  => $row[1],
                'machine_name'   => $row[2],
                'machine_brand'  => $row[3],
                'machine_type'   => $row[4],
                'machine_spec'   => $row[5],
                'mfg_number'     => $row[6],
                'production_date'=> $row[7],
                'machine_power'  => $row[8],
                'machine_made'   => $row[9],
                'install_date'   => $row[10],
                'machine_info'   => $row[11],
                'machine_number' => $row[12]
            ]);
        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            throw $e;
        }
    }
}
