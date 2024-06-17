<?php

namespace App\Imports;

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
        // Log::info('Row headers: ' . implode(', ', array_keys($row)));
        try {
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
