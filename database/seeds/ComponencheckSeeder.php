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
        // 1.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Panel Listrik',
        ]);
        // 2.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Kabel External ( Luar )',
        ]);
        // 3.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Sambungan Kabel',
        ]);
        // 4.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Torch Mount',
        ]);
        // 5.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Torch Aiming point',
        ]);
        // 6.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Welding torch
                                    - Hubungan Kabel
                                    - Worn Tip
                                    - Noozle
                                    - Torch Mounted',
        ]);
        // 7.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Wire feed Unit',
        ]);
        // 8.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Coaxial Kabel Power',
        ]);
        // 9.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Gas Hose ( Pipa Karet )',
        ]);
        // 10.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Welding Kabel Power',
        ]);
        // 11.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Feeder Terminal',
        ]);
        // 12.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Indicator system 1.ARC Control / ARC Force 2.Initial / Crater Curr 3.Start On - Of button 4.On - of Gas 5.On - of Wire dir 6.On - of Crater 7.Job Control',
        ]);
        // 13.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Volt Control & Digital Counter',
        ]);
        // 14.
        Componencheck::create([
            'id_property' => '1',
            'name_componencheck' => 'Reeder Termination',
        ]);
        // 15.
        Componencheck::create([
            'id_property' => '3',
            'name_componencheck' => 'Sambungan terminal elektrik',
        ]);
        // 16.
        Componencheck::create([
            'id_property' => '3',
            'name_componencheck' => '-Level fluida
                                    -Fillter mat',
        ]);
        // 17.
        Componencheck::create([
            'id_property' => '3',
            'name_componencheck' => 'Ditunjukan oleh sigma control

                                    -Saringan fluida

                                    -Catridge separator fluida

                                    -Cartridge saringan udara',
        ]);
        // 18.
        Componencheck::create([
            'id_property' => '3',
            'name_componencheck' => '-Pendinginan udara & fluida

                                    -Saringan udara',
        ]);
        // 19.
        Componencheck::create([
            'id_property' => '3',
            'name_componencheck' => 'Oli',
        ]);
        // 20.
        Componencheck::create([
            'id_property' => '2',
            'name_componencheck' => 'Electric System 1. MCCB / Breacker 2.Tegangan Listrik 3.Jaringan kabel listrik 4.Terminasi / sambungan 5.Kontraktor',
        ]);
        // 21.
        Componencheck::create([
            'id_property' => '2',
            'name_componencheck' => 'Operational Control 1.Power Feed Transmission 2.Supply Switch 3.Spindle brake and lock 4.Ram control Handle',
        ]);
        // 22.
        Componencheck::create([
            'id_property' => '2',
            'name_componencheck' => 'Motor 1.Pully 2.Belt 3.Speed 4.Bolt',
        ]);
        // 23.
        Componencheck::create([
            'id_property' => '2',
            'name_componencheck' => 'Lubrication 1.Bearing 2.Gear shaft 3.Sliding',
        ]);
    }
}
