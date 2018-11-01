<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProfileTableSeeder extends Seeder
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
            'name' => 'profile',
            'display_name' => 'Profile'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'update-own-profile',
                'display_name' => 'Update Own',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-all-profiles',
                'display_name' => 'Update All',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        $role = Role::findByName('admin');

        $role->givePermissionTo(Permission::all());

    }
}
