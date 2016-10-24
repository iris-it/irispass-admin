<?php

use App\Group;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the users seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();
        $statement = "ALTER TABLE groups AUTO_INCREMENT = 1;";
        DB::unprepared($statement);
        Schema::disableForeignKeyConstraints();

        //has organisation and is manager
        Group::create([
            'name' => 'group_test',
            'realname' => '4586e836-cd4a-4f30-b5b0-7abd9502a5e4#desktop',
            'organization_uuid' => '4586e836-cd4a-4f30-b5b0-7abd9502a5e4',
            'organization_id' => 1
        ]);

    }
}