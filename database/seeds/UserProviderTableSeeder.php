<?php

use App\UserProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserProviderTableSeeder extends Seeder
{
    /**
     * Run the users seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_identities')->delete();
        $statement = "ALTER TABLE oauth_identities AUTO_INCREMENT = 1;";
        DB::unprepared($statement);
        Schema::disableForeignKeyConstraints();

        UserProvider::create([
            'user_id' => 1,
            'provider_user_id' => 'f9dccb0f-6f97-4e9c-8da8-34fe3f128e1a',
            'provider' => 'keycloak',
            'access_token' => ''
        ]);

        UserProvider::create([
            'user_id' => 2,
            'provider_user_id' => '',
            'provider' => '',
            'access_token' => ''
        ]);

        UserProvider::create([
            'user_id' => 3,
            'provider_user_id' => '',
            'provider' => '',
            'access_token' => ''
        ]);

    }
}