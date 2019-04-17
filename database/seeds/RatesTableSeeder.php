<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RatesTableSeeder extends Seeder
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
            'name' => 'rates',
            'display_name' => 'Tarifas',
            'icon' => 'icon-user',
            'active' => false
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-rates',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-rates',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-rates',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-rates',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo(
            'read-rates',
            'create-rates',
            'update-rates',
            'delete-rates'
        );

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(
            'read-rates',
            'create-rates',
            'update-rates',
            'delete-rates'
        );
    }
}
