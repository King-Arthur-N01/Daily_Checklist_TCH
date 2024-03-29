<?php

use app\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin Web',
            'nik' => '11379',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');
    }
}
