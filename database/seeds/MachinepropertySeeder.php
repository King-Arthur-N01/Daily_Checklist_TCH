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
            'name_property' => 'WELD MACHINE'
        ]);
        // 2.
        Machineproperty::create([
            'name_property' => 'TAPPING MACHINE'
        ]);
        // 3.
        Machineproperty::create([
            'name_property' => 'COMPRESSOR MACHINE'
        ]);
    }
}
