<?php

use App\Machine;
use Illuminate\Database\Seeder;

class MachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Machine::create([
            'machine_code'  => '1',
            'invent_number' => 'E-AA-14-0102',
            'machine_name'  => 'POWER PRESS SEDANG',
            'machine_brand' => 'WORLD PRECISE PRESS',
            'machine_type'  => 'JS36-400',
            'machine_spec'  => '400 TON',
            'machine_made'  => 'CHINA',
            'mfg_number'    => '140107',
            'install_date'  => '2014-01-07'
        ]);
        Machine::create([
            'machine_code'  => '2',
            'invent_number' => 'E-AA-15-0105',
            'machine_name'  => 'POWER PRESS BESAR',
            'machine_brand' => 'WORLD PRECISE PRESS',
            'machine_type'  => 'JS36-500',
            'machine_spec'  => '500 TON',
            'machine_made'  => 'CHINA',
            'mfg_number'    => '150507',
            'install_date'  => '2015-05-07'
        ]);
        Machine::create([
            'machine_code'  => '3',
            'invent_number' => 'E-JG-21-0007',
            'machine_name'  => 'MESIN PORTABLE SPOT KECIL',
            'machine_brand' => 'NANCHI',
            'machine_type'  => '-',
            'machine_spec'  => '-',
            'machine_made'  => 'JAPAN',
            'mfg_number'    => 'B190206/94112',
            'install_date'  => '2021-04-21'
        ]);
        Machine::create([
            'machine_code'  => '4',
            'invent_number' => 'E-JG-19-23134',
            'machine_name'  => 'ROBOT SPOT BESAR',
            'machine_brand' => 'NANCHI',
            'machine_type'  => '-',
            'machine_spec'  => '-',
            'machine_made'  => 'JAPAN',
            'mfg_number'    => 'B19021/94113',
            'install_date'  => '2019-04-21'
        ]);
        Machine::create([
            'machine_code'  => '5',
            'invent_number' => 'F-DH-18-14512',
            'machine_name'  => 'PLC ROBOT',
            'machine_brand' => 'SCHNEIDER',
            'machine_type'  => 'PHM-129483OBJ',
            'machine_spec'  => '-',
            'machine_made'  => 'FRANCIS',
            'mfg_number'    => 'VG134510HH',
            'install_date'  => '2018-06-14'
        ]);
        Machine::create([
            'machine_code'  => '6',
            'invent_number' => 'F-DH-18-36421',
            'machine_name'  => 'PLC COUNTING',
            'machine_brand' => 'SEIMENS',
            'machine_type'  => 'PHM-9141HBM',
            'machine_spec'  => '-',
            'machine_made'  => 'FRANCIS',
            'mfg_number'    => 'SD08348Y1',
            'install_date'  => '2018-06-15'
        ]);
    }
}
