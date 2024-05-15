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
        Permission::create(['name' => 'create_form']);
        Permission::create(['name' => 'viewtable_form']);
        Permission::create(['name' => 'edit_form']);
        Permission::create(['name' => 'viewtable_records']);
        Permission::create(['name' => 'delete_records']);
        Permission::create(['name' => 'reject_records']);
        Permission::create(['name' => 'corrected_records']);
        Permission::create(['name' => 'approval_records']);
        Permission::create(['name' => 'managemachine']);
        Permission::create(['name' => 'manageuser']);
        Permission::create(['name' => 'permit']);
        Permission::create(['name' => 'restric']);

        //create roles and assign existing permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('viewtable_form');
        $userRole->givePermissionTo('create_form');
        $userRole->givePermissionTo('edit_form');

        $foremanRole = Role::create(['name' => 'foreman']);
        $foremanRole->givePermissionTo('viewtable_form');
        $foremanRole->givePermissionTo('edit_form');
        $foremanRole->givePermissionTo('delete_records');
        $foremanRole->givePermissionTo('corrected_records');
        $foremanRole->givePermissionTo('reject_records');
        $foremanRole->givePermissionTo('managemachine');

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo('viewtable_records');
        $managerRole->givePermissionTo('approval_records');
        $managerRole->givePermissionTo('reject_records');
        $managerRole->givePermissionTo('manageuser');

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create_form');
        $adminRole->givePermissionTo('viewtable_form');
        $adminRole->givePermissionTo('edit_form');
        $adminRole->givePermissionTo('viewtable_records');
        $adminRole->givePermissionTo('delete_records');
        $adminRole->givePermissionTo('reject_records');
        $adminRole->givePermissionTo('corrected_records');
        $adminRole->givePermissionTo('approval_records');
        $adminRole->givePermissionTo('managemachine');
        $adminRole->givePermissionTo('manageuser');
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

        $foreman = User::create([
            'name' => 'foreman',
            'nik' => '12345',
            'department' => 'Engginer',
            'password' => bcrypt('foreman123'),
        ]);
        $foreman->assignRole('foreman');

        $manager = User::create([
            'name' => 'manager',
            'nik' => '00000',
            'department' => 'Engginer',
            'password' => bcrypt('manager123'),
        ]);
        $manager->assignRole('manager');

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

        $user = User::create([
            'name' => 'User 4',
            'nik' => '44444',
            'status' => '0',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $user->assignRole('user');
    }
}
