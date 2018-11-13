<?php

use Illuminate\Database\Seeder;

class FakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($user) {

            $user->assignRole('user');

            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        });
    }
}
