<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polices', function (Blueprint $table) {
            $table->increments('Police_id');
            $table->string('Police_Name');
            $table->string('Police_lname');
            $table->string('Police_gender');
            $table->string('Police_bday');
            $table->string('Police_address');
            $table->string('Police_mobilenum');
            $table->string('Police_email');
            $table->string('Police_password');
            $table->string('Police_code')->nullable();
            $table->string('Police_picture');
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
        Schema::dropIfExists('polices');
    }
}
