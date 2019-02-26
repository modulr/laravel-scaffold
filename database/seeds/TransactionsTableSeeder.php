<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TransactionsTableSeeder extends Seeder
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
            'name' => 'transactions',
            'display_name' => 'Transactions',
            'icon' => 'icon-shuffle'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-transactions',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-transactions',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-transactions',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-transactions',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-transactions', 'create-transactions', 'update-transactions', 'delete-transactions');

        $user = Role::findByName('user');
        $user->givePermissionTo('read-transactions', 'create-transactions', 'update-transactions', 'delete-transactions');

        $guest = Role::findByName('guest');
        $guest->givePermissionTo('read-transactions');
    }
}
