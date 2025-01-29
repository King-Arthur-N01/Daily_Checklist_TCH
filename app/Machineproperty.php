<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class Machineproperty extends Model
{
    protected $fillable = [
        'name_property',
        'standart_checksheet'
    ];

    private $isFirstRow = true;

    public function collection(Collection $rows)
    {
        try {
            if ($this->isFirstRow) {
                $machineProperty = Machineproperty::create([
                    'name_property' => $row[0], // Ambil nama pada header file Excel
                ]);
            }

            foreach ($rows as $row) {
                // Simpan komponen
                $component = Componencheck::create([
                    'name_componencheck' => $row['BAGIAN YANG DICHECK'], // Sesuaikan dengan header file Excel
                    'id_property' => $machineProperty->id,
                ]);
                // Simpan parameter
                $parameter = Parameter::create([
                    'name_parameter' => $row["STANDARD/PARAMETER"], // Asumsikan parameter dipecah jadi parameter_0, parameter_1, dst.
                    'id_componencheck' => $component->id,
                ]);
                // Simpan metode
                Metodecheck::create([
                    'name_metodecheck' => $row["PARAMETER PENGECEKAN"], // Asumsikan metode dipecah jadi metode_0, metode_1, dst.
                    'id_parameter' => $parameter->id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getparentmachine()
    {
        return $this->hasMany(Machine::class);
    }
    public function getchilderncomponen()
    {
        return $this->hasMany(Componencheck::class);
    }
}
