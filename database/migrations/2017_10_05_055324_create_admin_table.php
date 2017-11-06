<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('Admin_id');
            $table->string('Admin_Name');
            $table->string('Admin_lname');
            $table->string('Admin_gender');
            $table->string('Admin_bday');
            $table->string('Admin_address');
            $table->string('Admin_mobilenum');
            $table->string('Admin_email');
            $table->string('Admin_password');
            $table->string('Admin_code')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
