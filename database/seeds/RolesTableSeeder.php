<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
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
            'name' => 'roles',
            'display_name' => 'Roles',
            'icon' => 'mdi-vpn-key'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Default Role
        $role = Role::create([
            'name' => 'admin'
        ]);

        $role->givePermissionTo(Permission::all());
    }
}
