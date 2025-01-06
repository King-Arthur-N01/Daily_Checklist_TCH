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
        Permission::create(['name' => 'view_records']);
        Permission::create(['name' => 'delete_records']);
        Permission::create(['name' => 'corrected_records']);
        Permission::create(['name' => 'approval_records']);

        Permission::create(['name' => 'create_schedule']);
        Permission::create(['name' => 'edit_schedule']);
        Permission::create(['name' => 'recognize_schedule']);
        Permission::create(['name' => 'agreed_schedule']);
        Permission::create(['name' => 'reschedule_schedule']);
        Permission::create(['name' => 'view_schedule']);

        Permission::create(['name' => 'manage_machine']);
        Permission::create(['name' => 'manage_user']);
        Permission::create(['name' => 'permit']);
        Permission::create(['name' => 'restric']);
        Permission::create(['name' => 'modify_data']);

        //create roles and assign existing permissions
        $plannerRole = Role::create(['name' => 'planner']);
        $plannerRole->givePermissionTo('create_schedule');
        $plannerRole->givePermissionTo('reschedule_schedule');
        $plannerRole->givePermissionTo('view_schedule');

        $operatorRole = Role::create(['name' => 'operator']);
        $operatorRole->givePermissionTo('create_records');
        $operatorRole->givePermissionTo('view_records');
        $operatorRole->givePermissionTo('create_schedule');
        $operatorRole->givePermissionTo('edit_schedule');
        $operatorRole->givePermissionTo('view_schedule');

        $leaderRole = Role::create(['name' => 'leader']);
        $leaderRole->givePermissionTo('create_records');
        $leaderRole->givePermissionTo('edit_records');
        $leaderRole->givePermissionTo('view_records');
        $leaderRole->givePermissionTo('corrected_records');
        $leaderRole->givePermissionTo('create_schedule');
        $leaderRole->givePermissionTo('edit_schedule');
        $leaderRole->givePermissionTo('view_schedule');
        $leaderRole->givePermissionTo('agreed_schedule');
        $leaderRole->givePermissionTo('manage_machine');

        $foremanRole = Role::create(['name' => 'foreman']);
        $foremanRole->givePermissionTo('create_records');
        $foremanRole->givePermissionTo('edit_records');
        $foremanRole->givePermissionTo('view_records');
        $foremanRole->givePermissionTo('corrected_records');
        $foremanRole->givePermissionTo('create_schedule');
        $foremanRole->givePermissionTo('edit_schedule');
        $foremanRole->givePermissionTo('view_schedule');
        $foremanRole->givePermissionTo('agreed_schedule');
        $foremanRole->givePermissionTo('manage_machine');
        $foremanRole->givePermissionTo('manage_user');

        $supervisorRole = Role::create(['name' => 'supervisor']);
        $supervisorRole->givePermissionTo('create_records');
        $supervisorRole->givePermissionTo('edit_records');
        $supervisorRole->givePermissionTo('view_records');
        $supervisorRole->givePermissionTo('corrected_records');
        $supervisorRole->givePermissionTo('approval_records');
        $supervisorRole->givePermissionTo('create_schedule');
        $supervisorRole->givePermissionTo('edit_schedule');
        $supervisorRole->givePermissionTo('view_schedule');
        $supervisorRole->givePermissionTo('agreed_schedule');
        $supervisorRole->givePermissionTo('recognize_schedule');
        $supervisorRole->givePermissionTo('manage_machine');
        $supervisorRole->givePermissionTo('manage_user');

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo('create_records');
        $managerRole->givePermissionTo('edit_records');
        $managerRole->givePermissionTo('edit_records');
        $managerRole->givePermissionTo('view_records');
        $managerRole->givePermissionTo('corrected_records');
        $managerRole->givePermissionTo('approval_records');
        $managerRole->givePermissionTo('create_schedule');
        $managerRole->givePermissionTo('edit_schedule');
        $managerRole->givePermissionTo('view_schedule');
        $managerRole->givePermissionTo('agreed_schedule');
        $managerRole->givePermissionTo('recognize_schedule');
        $managerRole->givePermissionTo('manage_machine');
        $managerRole->givePermissionTo('manage_user');

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create_records');
        $adminRole->givePermissionTo('edit_records');
        $adminRole->givePermissionTo('view_records');
        $adminRole->givePermissionTo('delete_records');
        $adminRole->givePermissionTo('corrected_records');
        $adminRole->givePermissionTo('approval_records');
        $adminRole->givePermissionTo('create_schedule');
        $adminRole->givePermissionTo('edit_schedule');
        $adminRole->givePermissionTo('view_schedule');
        $adminRole->givePermissionTo('agreed_schedule');
        $adminRole->givePermissionTo('recognize_schedule');
        $adminRole->givePermissionTo('reschedule_schedule');
        $adminRole->givePermissionTo('view_schedule');
        $adminRole->givePermissionTo('manage_machine');
        $adminRole->givePermissionTo('manage_user');
        $adminRole->givePermissionTo('permit');
        $adminRole->givePermissionTo('restric');
        $adminRole->givePermissionTo('modify_data');

        // create demo users
        $admin = User::create([
            'name' => 'System-Admin',
            'nik' => '11379',
            'department' => 'IT',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');

        $manager = User::create([
            'name' => 'SENTOT N.B.',
            'nik' => '11111',
            'department' => 'Engginer',
            'password' => bcrypt('manager123'),
        ]);
        $manager->assignRole('manager');

        $supervisor = User::create([
            'name' => 'MARGONO (B)',
            'nik' => '22222',
            'department' => 'Engginer',
            'password' => bcrypt('supervisor123'),
        ]);
        $supervisor->assignRole('supervisor');

        $foreman = User::create([
            'name' => 'M. SAMSUL MUHANAN',
            'nik' => '33333',
            'department' => 'Engginer',
            'password' => bcrypt('foreman123'),
        ]);
        $foreman->assignRole('foreman');

        $leader = User::create([
            'name' => 'ERWANTO',
            'nik' => '44444',
            'department' => 'Engginer',
            'password' => bcrypt('leader123'),
        ]);
        $leader->assignRole('leader');

        $operator = User::create([
            'name' => 'NUR KHAYU L GHANI',
            'nik' => '123456789',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $operator = User::create([
            'name' => 'M. YAKUB ISKANDAR',
            'nik' => '12345',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $operator = User::create([
            'name' => 'DEDI ARIVIYANTO',
            'nik' => '13579',
            'status' => '0',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $operator = User::create([
            'name' => 'BEKHAN S.',
            'nik' => '24680',
            'status' => '0',
            'department' => 'Engginer',
            'password' => bcrypt('user123'),
        ]);
        $operator->assignRole('operator');

        $planner = User::create([
            'name' => 'EVAN',
            'nik' => '00000',
            'status' => '1',
            'department' => 'Planner',
            'password' => bcrypt('user123'),
        ]);
        $planner->assignRole('operator');
    }
}
