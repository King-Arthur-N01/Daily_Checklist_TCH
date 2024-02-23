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
            'name_parameter' => 'Dibersihkan',
        ]);
        Parameter::create([
            'id_parameter'  => '2',
            'name_parameter' => 'Terkunci',
        ]);
        Parameter::create([
            'id_parameter'  => '3',
            'name_parameter' => 'Berfungsi dengan baik',
        ]);
        Parameter::create([
            'id_parameter'  => '4',
            'name_parameter' => 'Kondisi Normal',
        ]);
        Parameter::create([
            'id_parameter'  => '5',
            'name_parameter' => 'Tidak goyang',
        ]);
        Parameter::create([
            'id_parameter'  => '6',
            'name_parameter' => 'Terpasang Kencang',
        ]);
    }
}
