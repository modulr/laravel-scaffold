<?php

use Illuminate\Database\Seeder;

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
        $usersId = DB::table('modules')->insertGetId([
            'name' => 'users',
            'display_name' => 'Users',
            'icon' => 'mdi-people'
        ]);

        // Permissions
        Spatie\Permission\Models\Permission::insert([
            [
                'name' => 'read-users',
                'module_id' => $usersId
            ],
            [
                'name' => 'create-users',
                'module_id' => $usersId
            ],
            [
                'name' => 'update-users',
                'module_id' => $usersId
            ],
            [
                'name' => 'delete-users',
                'module_id' => $usersId
            ]
        ]);

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
