<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CompaniesTableSeeder extends Seeder
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
            'name' => 'companies',
            'display_name' => 'Companies',
            'icon' => 'icon-briefcase'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-companies',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-companies',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-companies',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-companies',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-companies', 'create-companies', 'update-companies', 'delete-companies');

        $user = Role::findByName('user');
        $user->givePermissionTo('read-companies', 'create-companies', 'update-companies', 'delete-companies');

        $guest = Role::findByName('guest');
        $guest->givePermissionTo('read-companies');
    }
}
