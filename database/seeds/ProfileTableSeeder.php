<?php

use Illuminate\Database\Seeder;

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
        Spatie\Permission\Models\Permission::create([
            [
                'name' => 'update-own-profile',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-all-profiles',
                'module_id' => $moduleId
            ]
        ]);

    }
}
