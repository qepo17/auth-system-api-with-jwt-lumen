<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('bio', 255)->nullable();
            $table->string('github', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('location')->nullable();
            $table->bigInteger('viewers')->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
