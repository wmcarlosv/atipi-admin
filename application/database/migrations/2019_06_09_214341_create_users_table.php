<?php

use Illuminate\Support\Facades\Schema;
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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone',30)->nullable(false);
            $table->bigInteger('country_id')->unsigned();
            $table->string('location',255)->nullable();
            $table->string('avatar',150)->nullable();
            $table->enum('role',['administrator','viewer'])->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status',['email_verification','active','service_inactive','inactive'])->nullable(false);
            $table->string('code_verfication',150)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('restrict')->onUpdate('restrict');
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
