<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleTableSeeder::class);
        $this->call(LicenceTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserProviderTableSeeder::class);
        $this->call(OrganizationTableSeeder::class);
        $this->call(GroupTableSeeder::class);

    }
}
