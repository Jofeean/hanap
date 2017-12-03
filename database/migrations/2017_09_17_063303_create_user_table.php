<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('User_id');
            $table->string('User_fname');
            $table->string('User_mname')->nullable();
            $table->string('User_lname');

            $table->string('User_gender');
            $table->string('User_bday');
            $table->string('User_address');
            $table->string('User_city');

            $table->string('User_email');
            $table->string('User_password');
            $table->string('User_mobilenum');

            $table->string('User_status')->default('0');
            $table->string('User_code')->nullable();
            $table->string('User_picture');
            $table->string('User_valId1');
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
