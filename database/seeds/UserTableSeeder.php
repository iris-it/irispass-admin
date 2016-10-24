<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the users seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $statement = "ALTER TABLE users AUTO_INCREMENT = 1;";
        DB::unprepared($statement);
        Schema::disableForeignKeyConstraints();

        //has organisation and is manager
        User::create([
            'sub' => 'f9dccb0f-6f97-4e9c-8da8-34fe3f128e1a',
            'name' => 'John Doe',
            'preferred_username' => 'john_doe',
            'given_name' => 'John',
            'family_name' => 'Doe',
            'email' => 'john.doe@mail.com',
            'role_id' => 2,
            'organization_id' => 1
        ]);

        //has no organization and no role
        User::create([
            'sub' => 'f9dccb0f-6f97-4e9c-8da8-34fe3f128e1a',
            'name' => 'Mike Doe',
            'preferred_username' => 'mike_doe',
            'given_name' => 'Mike',
            'family_name' => 'Doe',
            'email' => 'mike.doe@mail.com',
        ]);

        //is user of one organization
        User::create([
            'sub' => 'f9dccb0f-6f97-4e9c-8da8-34fe3f128e1a',
            'name' => 'Ron Doe',
            'preferred_username' => 'ron_doe',
            'given_name' => 'Ron',
            'family_name' => 'Doe',
            'email' => 'ron.doe@mail.com',
            'role_id' => 3,
            'organization_id' => 1
        ]);

    }
}