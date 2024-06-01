<?php

namespace App\Imports;

use App\Machine;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
class Importdata implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Importing row: ', $row);
        try {
            return new Machine([
                'invent_number'  => $row['Invent Number'],
                'machine_number' => $row['Machine Number'],
                'machine_name'   => $row['Machine Name'],
                'machine_brand'  => $row['Machine Brand'],
                'machine_type'   => $row['Machine Type'],
                'machine_spec'   => $row['Machine Spec'],
                'machine_made'   => $row['Machine Made'],
                'mfg_number'     => $row['MFG Number'],
                'install_date'   => $row['Install Date']
            ]);
        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            return null;
        }
    }
    public function rules(): array
    {
        return [
            '*.Invent Number' => ['required', 'string'],
            '*.Machine Number' => ['required', 'int'],
            '*.Machine Name' => ['required', 'string'],
            '*.Machine Brand' => ['required', 'string'],
            '*.Machine Type' => ['required', 'string'],
            '*.Machine Spec' => ['required', 'string'],
            '*.Machine Made' => ['required', 'string'],
            '*.MFG Number' => ['required', 'string'],
            '*.Install Date' => ['required', 'string'],
        ];
    }
}
