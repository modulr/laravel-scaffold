<?php

use Illuminate\Database\Seeder;

class DashboardTableSeeder extends Seeder
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
            'name' => 'dashboard',
            'display_name' => 'Dashboard',
            'icon' => 'icon-speedometer'
        ]);
    }
}
