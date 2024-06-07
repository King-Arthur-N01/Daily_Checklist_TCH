<?php

use App\Machineproperty;
use Illuminate\Database\Seeder;

class MachinepropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1.
        Machineproperty::create([
            'standart_name' => 'WELD MACHINE'
        ]);
        // 2.
        Machineproperty::create([
            'standart_name' => 'STAMP MACHINE'
        ]);
        // 3.
        Machineproperty::create([
            'standart_name' => 'COMPRESSOR MACHINE'
        ]);
    }
}
