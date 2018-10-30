<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'icon' => 'mdi-people'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        $role = Role::findByName('admin');

        $role->givePermissionTo(Permission::all());

        // Default User
        $user = \App\User::create([
            'name' => 'admin',
            'email' => 'admin@modulr.io',
            'password' => bcrypt('admin'),
            'avatar' => 'avatar.png'
        ]);

        // Assign Admin Role
        $user->assignRole('admin');

        // Generate avatar
        $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        // factory(App\User::class, 50)->create()->each(function ($user) {
        //     $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        //     Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);
        // });
    }
}
