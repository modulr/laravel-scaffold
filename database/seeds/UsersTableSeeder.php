<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
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
            'name' => 'users',
            'display_name' => 'Users',
            'icon' => 'icon-people'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-users',
                'display_name' => 'Read',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-users',
                'display_name' => 'Create',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-users',
                'display_name' => 'Update',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-users',
                'display_name' => 'Delete',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions to superadmin role
        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo(
            'read-users',
            'create-users',
            'update-users',
            'delete-users'
        );

        // // Create superadmin user
        // $user = \App\User::create([
        //     'name' => 'superadmin',
        //     'email' => 'superadmin@modulr.io',
        //     'password' => bcrypt('superadmin'),
        //     'avatar' => 'avatar.png'
        // ]);
        // // Assign superadmin role to superadmin user
        // $user->assignRole('superadmin');
        // // Generate avatar to defautl user
        // $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        // Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);
    }
}
