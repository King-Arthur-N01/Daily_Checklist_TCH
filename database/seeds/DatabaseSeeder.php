<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call([
        PermissionSeeder::class,
        // MachinepropertySeeder::class,
        // ComponencheckSeeder::class,
        // ParameterSeeder::class,
        // MetodecheckSeeder::class,
        // MachinesSeeder::class,
        ]);
    }
}
