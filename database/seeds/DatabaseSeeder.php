<?php

use Illuminate\Database\Seeder;
use Irisit\IrispassShared\Seeders\LicenceTableSeeder;
use Irisit\IrispassShared\Seeders\RoleTableSeeder;

class DatabaseSeeder extends Seeder
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
    }
}
