<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'approval']);
        Permission::create(['name' => 'register']);
        Permission::create(['name' => 'permit']);
        Permission::create(['name' => 'restric']);

        //create roles and assign existing permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('view');
        $userRole->givePermissionTo('create');

        $leaderRole = Role::create(['name' => 'leader']);
        $leaderRole->givePermissionTo('approval');
        $leaderRole->givePermissionTo('register');

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('view');
        $adminRole->givePermissionTo('create');
        $adminRole->givePermissionTo('edit');
        $adminRole->givePermissionTo('delete');
        $adminRole->givePermissionTo('approval');
        $adminRole->givePermissionTo('register');
        $adminRole->givePermissionTo('permit');
        $adminRole->givePermissionTo('restric');

        // create demo users
        $admin = User::create([
            'name' => 'Admin',
            'nik' => '11379',
            'department' => 'IT',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');

        $leader = User::create([
            'name' => 'Leader',
            'nik' => '12345',
            'department' => 'Engginer',
            'password' => bcrypt('leader123'),
        ]);
        $leader->assignRole('leader');

        $user = User::create([
            'name' => 'User 1',
            'nik' => '11111',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'User 2',
            'nik' => '22222',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'User 3',
            'nik' => '33333',
            'status' => '0',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $user->assignRole('user');
    }
}
