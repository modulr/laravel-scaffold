<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OrdersTableSeeder extends Seeder
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
            'name' => 'orders',
            'display_name' => 'Mandados',
            'icon' => 'icon-user',
            'active' => false
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-orders',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-orders',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-orders',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-orders',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $user = Role::findByName('user');
        $user->givePermissionTo('read-orders', 'create-orders', 'update-orders', 'delete-orders');

        $user = Role::findByName('dealer');
        $user->givePermissionTo('read-orders', 'create-orders', 'update-orders', 'delete-orders');


        DB::table('order_status')->insert([
            [
                'status' => 'Abierto'
            ],
            [
                'status' => 'En curso'
            ],
            [
                'status' => 'Finalizado'
            ],
            [
                'status' => 'Cancelado'
            ]
        ]);
    }
}
