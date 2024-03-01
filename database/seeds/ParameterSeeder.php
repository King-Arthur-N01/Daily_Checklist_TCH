<?php

use App\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parameter::create([
            'id_parameter'  => '1',
            'componencheck_parameter' => '1',
            'name_parameter' => 'Berfungsi Baik',
        ]);
        Parameter::create([
            'id_parameter'  => '2',
            'componencheck_parameter' => '2',
            'name_parameter' => 'Berfungsi dengan Baik',
        ]);
        Parameter::create([
            'id_parameter'  => '3',
            'componencheck_parameter' => '3',
            'name_parameter' => 'Berfungsi dengan baik',
        ]);
        Parameter::create([
            'id_parameter'  => '4',
            'componencheck_parameter' => '3',
            'name_parameter' => 'Dibershikan dari debu',
        ]);
        Parameter::create([
            'id_parameter'  => '5',
            'componencheck_parameter' => '4',
            'name_parameter' => 'Diganti setiap 2thn',
        ]);
        Parameter::create([
            'id_parameter'  => '6',
            'componencheck_parameter' => '5',
            'name_parameter' => 'Bersih dari debu',
        ]);
        Parameter::create([
            'id_parameter'  => '7',
            'componencheck_parameter' => '6',
            'name_parameter' => 'Ganti jika ada baut yang hilang',
        ]);
        Parameter::create([
            'id_parameter'  => '8',
            'componencheck_parameter' => '6',
            'name_parameter' => 'Terpasang dengan kencang',
        ]);
        Parameter::create([
            'id_parameter'  => '9',
            'componencheck_parameter' => '22',
            'name_parameter' => 'Terkunci',
        ]);
        Parameter::create([
            'id_parameter'  => '10',
            'componencheck_parameter' => '21',
            'name_parameter' => 'Dibersihkan dari oli dan juga debu',
        ]);
    }
}
