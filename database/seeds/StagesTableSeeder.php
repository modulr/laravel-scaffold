<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class StagesTableSeeder extends Seeder
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
            'name' => 'stages',
            'display_name' => 'Stages',
            'icon' => 'icon-briefcase'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-stages',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-stages',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-stages',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-stages',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions to admin role
        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-stages', 'create-stages', 'update-stages', 'delete-stages');

        $user = Role::findByName('user');
        $user->givePermissionTo('read-stages', 'create-stages', 'update-stages', 'delete-stages');

        $guest = Role::findByName('guest');
        $guest->givePermissionTo('read-stages', 'update-stages');
    }
}
