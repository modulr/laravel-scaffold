<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => 'address',
            'display_name' => 'Direcciones',
            'icon' => 'icon-user',
            'active' => false
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-address',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-address',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-address',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-address',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions to admin role
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        // Assign permissions to user role
        $user = Role::findByName('user');
        $user->givePermissionTo('read-address', 'create-address', 'update-address', 'delete-address');

    }
}
