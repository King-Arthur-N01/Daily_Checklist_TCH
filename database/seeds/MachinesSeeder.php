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
            // 'machine_code'  => '1',
            'invent_number' => 'E-JG-09-0043',
            'machine_number'=> 'S.10',
            'machine_name'  => 'INVERTER WELD',
            'machine_brand' => 'OTC',
            'machine_type'  => 'DM-350',
            'machine_spec'  => '350 A',
            'machine_made'  => 'JAPAN',
            'mfg_number'    => 'P10327YDZ158301001',
            'install_date'  => '2009',
            'property_id'   => '1'
        ]);
        Machine::create([
            // 'machine_code'  => '2',
            'invent_number' => 'E-JG-09-0064',
            'machine_number'=> 'S.15',
            'machine_name'  => 'INVERTER WELD',
            'machine_brand' => 'PANASONIC',
            'machine_type'  => 'YD-350GR3',
            'machine_spec'  => '350 A',
            'machine_made'  => 'JAPAN',
            'mfg_number'    => 'D 0650',
            'install_date'  => '2009',
            'property_id'   => '1'
        ]);
        Machine::create([
            // 'machine_code'  => '7',
            'invent_number' => 'F-AA-04-0037',
            'machine_number' => 'C.12',
            'machine_name'  => 'SCREW COMPRESSORE',
            'machine_brand' => 'GRECOMP',
            'machine_type'  => 'GCP-30',
            'machine_spec'  => '8,5 BAR',
            'machine_made'  => 'IND',
            'mfg_number'    => '200505',
            'install_date'  => '2012-02-20',
            'property_id'   => '3'
        ]);
    }
}
