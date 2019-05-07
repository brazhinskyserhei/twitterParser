<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo');
            $table->string('name');
            $table->string('twitter_id')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('tweets');
            $table->unsignedBigInteger('following');
            $table->unsignedBigInteger('followers');
            $table->unsignedBigInteger('likes');
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
        Schema::dropIfExists('twitter_users');
    }
}
