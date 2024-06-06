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
        // Permission::create(['name' => 'create_form']);
        // Permission::create(['name' => 'viewtable_form']);
        // Permission::create(['name' => 'edit_form']);

        Permission::create(['name' => 'create_records']);
        Permission::create(['name' => 'edit_records']);
        Permission::create(['name' => 'viewtable_records']);
        Permission::create(['name' => 'delete_records']);
        Permission::create(['name' => 'corrected_records']);
        Permission::create(['name' => 'approval_records']);
        Permission::create(['name' => 'managemachine']);
        Permission::create(['name' => 'manageuser']);
        Permission::create(['name' => 'permit']);
        Permission::create(['name' => 'restric']);

        //create roles and assign existing permissions
        $operatorRole = Role::create(['name' => 'operator']);
        $operatorRole->givePermissionTo('create_records');
        $operatorRole->givePermissionTo('viewtable_records');

        $leaderRole = Role::create(['name' => 'leader']);
        $leaderRole->givePermissionTo('create_records');
        $leaderRole->givePermissionTo('edit_records');
        $leaderRole->givePermissionTo('viewtable_records');
        $leaderRole->givePermissionTo('corrected_records');
        $leaderRole->givePermissionTo('managemachine');

        $foremanRole = Role::create(['name' => 'foreman']);
        $foremanRole->givePermissionTo('create_records');
        $foremanRole->givePermissionTo('edit_records');
        $foremanRole->givePermissionTo('viewtable_records');
        $foremanRole->givePermissionTo('corrected_records');
        $foremanRole->givePermissionTo('managemachine');
        $foremanRole->givePermissionTo('manageuser');

        $supervisorRole = Role::create(['name' => 'supervisor']);
        $supervisorRole->givePermissionTo('create_records');
        $supervisorRole->givePermissionTo('edit_records');
        $supervisorRole->givePermissionTo('delete_records');
        $supervisorRole->givePermissionTo('viewtable_records');
        $supervisorRole->givePermissionTo('corrected_records');
        $supervisorRole->givePermissionTo('approval_records');
        $supervisorRole->givePermissionTo('manageuser');

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo('create_records');
        $managerRole->givePermissionTo('edit_records');
        $managerRole->givePermissionTo('edit_records');
        $managerRole->givePermissionTo('delete_records');
        $managerRole->givePermissionTo('viewtable_records');
        $managerRole->givePermissionTo('corrected_records');
        $managerRole->givePermissionTo('approval_records');
        $managerRole->givePermissionTo('managemachine');
        $managerRole->givePermissionTo('manageuser');

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create_records');
        $adminRole->givePermissionTo('edit_records');
        $adminRole->givePermissionTo('viewtable_records');
        $adminRole->givePermissionTo('delete_records');
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

        $manager = User::create([
            'name' => 'Manager',
            'nik' => '11111',
            'department' => 'Engginer',
            'password' => bcrypt('manager123'),
        ]);
        $manager->assignRole('manager');

        $supervisor = User::create([
            'name' => 'Supervisor',
            'nik' => '22222',
            'department' => 'Engginer',
            'password' => bcrypt('supervisor123'),
        ]);
        $supervisor->assignRole('supervisor');

        $foreman = User::create([
            'name' => 'Foreman',
            'nik' => '33333',
            'department' => 'Engginer',
            'password' => bcrypt('foreman123'),
        ]);
        $foreman->assignRole('foreman');

        $leader = User::create([
            'name' => 'Leader',
            'nik' => '44444',
            'department' => 'Engginer',
            'password' => bcrypt('leader123'),
        ]);
        $leader->assignRole('leader');

        $operator = User::create([
            'name' => 'Operator 1',
            'nik' => '09876',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $operator = User::create([
            'name' => 'Operator 2',
            'nik' => '12345',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $operator = User::create([
            'name' => 'Operator 3',
            'nik' => '13812',
            'status' => '0',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $operator = User::create([
            'name' => 'Operator 4',
            'nik' => '10243',
            'status' => '0',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');
    }
}
