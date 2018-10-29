<?php

use Illuminate\Database\Seeder;

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
        $rolesId = DB::table('modules')->insertGetId([
            'name' => 'roles',
            'display_name' => 'Roles',
            'icon' => 'mdi-vpn-key'
        ]);

        // Permissions
        Spatie\Permission\Models\Permission::create([
            [
                'name' => 'read-roles',
                'module_id' => $rolesId
            ],
            [
                'name' => 'create-roles',
                'module_id' => $rolesId
            ],
            [
                'name' => 'update-roles',
                'module_id' => $rolesId
            ],
            [
                'name' => 'delete-roles',
                'module_id' => $rolesId
            ]
        ]);

        // Default Role
        $role = \App\Role::create([
            'name' => 'admin'
        ]);
    }
}
