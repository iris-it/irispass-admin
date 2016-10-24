<?php

use App\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the users seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->delete();
        $statement = "ALTER TABLE organizations AUTO_INCREMENT = 1;";
        DB::unprepared($statement);
        Schema::disableForeignKeyConstraints();

        Organization::create([
            'uuid' => '084bfedb-4aba-481c-b01f-8f3f822298c1',
            'name' => 'Acme LTD',
            'address' => '4 duck street',
            'address_comp' => '3rd flood, 1st office',
            'phone' => '+33564381765',
            'email' => 'acme.corp@mail.fr',
            'website' => 'www.acme.com',
            'is_active' => 1,
            'status' => 'LTD',
            'siret_number' => '00100200300556',
            'siren_number' => '001002003',
            'tva_number' => 'FR00001002020',
            'ape_number' => '13.37',
            'owner_id' => 1
        ]);

    }
}