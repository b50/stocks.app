<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name', 40);
            $table->string('last_name', 70);
            $table->string('email', 70)->unique();
            $table->string('password', 60);
            $table->text('about')->nullable();
            $table->string('group', 40);
            $table->string('street1');
            $table->string('street2')->nullable();
            $table->string('city');
            $table->string('region')->nullable();
            $table->string('post_code', 50);
            $table->string('country', 80);
            $table->string('mobile', 50)->nullable();
            $table->string('home_phone', 50)->nullable();
            $table->string('work_phone', 50)->nullable();
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
        Schema::drop('users');
    }
}
