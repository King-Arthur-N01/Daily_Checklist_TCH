<?php

use App\Componencheck;
use Illuminate\Database\Seeder;

class ComponencheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Componencheck::create([
            'id_Componencheck'  => '1',
            'name_Componencheck' => 'Vanbelt',
        ]);
        Componencheck::create([
            'id_Componencheck'  => '2',
            'name_Componencheck' => 'Motor',
        ]);
        Componencheck::create([
            'id_Componencheck'  => '3',
            'name_Componencheck' => 'Push button',
        ]);
        Componencheck::create([
            'id_Componencheck'  => '4',
            'name_Componencheck' => 'Oli mesin',
        ]);
        Componencheck::create([
            'id_Componencheck'  => '5',
            'name_Componencheck' => 'Selenoid valve',
        ]);
        Componencheck::create([
            'id_Componencheck'  => '6',
            'name_Componencheck' => 'Mur & baut',
        ]);
    }
}
