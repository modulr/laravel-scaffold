<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FilesTableSeeder extends Seeder
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
            'name' => 'files',
            'display_name' => 'Files',
            'icon' => 'icon-briefcase'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-files',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-files',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-files',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-files',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-files', 'create-files', 'update-files', 'delete-files');

        $user = Role::findByName('user');
        $user->givePermissionTo('read-files', 'create-files', 'delete-files');

        $guest = Role::findByName('guest');
        $guest->givePermissionTo('read-files', 'create-files', 'delete-files');
    }
}
