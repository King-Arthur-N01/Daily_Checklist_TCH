<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Componencheck;
use App\Parameter;
use App\Metodecheck;
// use Maatwebsite\Excel\Concerns\Model;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Machine extends Model
{
    protected $fillable = [
        'invent_number',
        'machine_number',
        'machine_name',
        'machine_brand',
        'machine_type',
        'machine_spec',
        'machine_made',
        'mfg_number',
        'install_date'
    ];
    public function model(array $row)
    {
        return new Machine([
            'nomor_invent' => $row['nomor_invent'],
            'nama_mesin' => $row['nama_mesin'],
            'brand_merk' => $row['brand_merk'],
            'model_type' => $row['model_type'],
            'spec_tonage' => $row['spec_tonage'],
            'buatan' => $row['buatan'],
            'mfg_number' => $row['mfg_number'],
            'install_date' => $row['install_date'],
        ]);
    }
    public function getchilderncomponen()
    {
        return $this->belongsTo(Componencheck::class);
    }
    public function getchildernrecord()
    {
        return $this->belongsTo(Machinerecord::class);
    }
    // public function importmachinedata(array $row)
    // {
    //     // table 1
    //     if ($row[0] == 'Condition1') {
    //         return new Machine([
    //             'id' => $row[0],
    //             'invent_number' => $row[1],
    //             'machine_number' => $row[2],
    //             'machine_name' => $row[3],
    //             'machine_brand' => $row[4],
    //             'machine_type' => $row[5],
    //             'machine_spec' =>  $row[6],
    //             'machine_made' => $row[7],
    //             'mfg_number' => $row[8],
    //             'install_date' => $row[9]
    //         ]);
    //     }
    //     //table 2
    //     if ($row[0] == 'Condition2') {
    //         return new Componencheck([
    //             'name_componencheck' => $row[10],
    //         ]);
    //     // table 3
    //     }elseif ($row[1] == 'Condition3') {
    //         return new Parameter([
    //             'name_parameter' => $row[11],
    //         ]);
    //     // table 4
    //     }elseif ($row[2] == 'Condition4') {
    //         return new Metodecheck([
    //             'name_metodecheck' => $row[12],
    //         ]);
    //     }
    // }
}
