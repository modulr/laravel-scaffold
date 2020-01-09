<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
        $this->call(DashboardTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(RatesTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(DealersTableSeeder::class);
    }
}
