<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminCreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('full_path');
            $table->string('virtual_path');
            $table->string('mime');

            $table->longText('users')->nullable();
            $table->longText('groups')->nullable();
            $table->longText('organizations')->nullable();

            $table->timestamp('lifetime')->nullable();
            $table->boolean('is_directory')->false();
            $table->boolean('is_public')->false();
            $table->string('owner_id')->false();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
