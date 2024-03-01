<?php

use App\Metodecheck;
use Illuminate\Database\Seeder;

class MetodecheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Metodecheck::create([
            'id_metodecheck'  => '1',
            'parameter_metodecheck' => '10',
            'name_metodecheck' => 'Dilihat',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '2',
            'parameter_metodecheck' => '3',
            'name_metodecheck' => 'Dioperasikan',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '3',
            'parameter_metodecheck' => '5',
            'name_metodecheck' => 'Lihat riwayat mesin',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '4',
            'parameter_metodecheck' => '8',
            'name_metodecheck' => 'Dikunci',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '5',
            'parameter_metodecheck' => '10',
            'name_metodecheck' => 'Dilihat',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '6',
            'parameter_metodecheck' => '7',
            'name_metodecheck' => 'Dilihat',
        ]);
    }
}
