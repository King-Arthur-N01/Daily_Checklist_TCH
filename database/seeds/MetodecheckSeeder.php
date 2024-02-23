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
            'name_metodecheck' => 'Dilihat',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '2',
            'name_metodecheck' => 'Dioperasikan',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '3',
            'name_metodecheck' => 'Didengar',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '4',
            'name_metodecheck' => 'Ditester',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '5',
            'name_metodecheck' => 'Dicium',
        ]);
        Metodecheck::create([
            'id_metodecheck'  => '6',
            'name_metodecheck' => 'Dicheck',
        ]);
    }
}
