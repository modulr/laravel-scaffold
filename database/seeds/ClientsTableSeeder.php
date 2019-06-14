<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'clients';

        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => $name,
            'display_name' => ucwords($name),
            'icon' => 'icon-user',
            'active' => true
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-'.$name,
                'display_name' => 'Read '.$name,
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-'.$name,
                'display_name' => 'Create '.$name,
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-'.$name,
                'display_name' => 'Update '.$name,
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-'.$name,
                'display_name' => 'Delete '.$name,
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo(
            'read-'.$name,
            'create-'.$name,
            'update-'.$name,
            'delete-'.$name
        );

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(
            'read-'.$name,
            'create-'.$name,
            'update-'.$name,
            'delete-'.$name
        );

    }
}
