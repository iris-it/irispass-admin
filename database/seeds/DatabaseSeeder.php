<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        if (env('APP_ENV' === 'testing')) {
            $this->call(RoleTableSeeder::class);
            $this->call(LicenceTableSeeder::class);
            $this->call(UserTableSeeder::class);
            $this->call(UserProviderTableSeeder::class);
            $this->call(OrganizationTableSeeder::class);
        } else {
            $this->call(RoleTableSeeder::class);
            $this->call(LicenceTableSeeder::class);
        }


        Schema::enableForeignKeyConstraints();
    }
}
