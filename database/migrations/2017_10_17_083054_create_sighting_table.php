<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSightingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sightings', function (Blueprint $table) {
            $table->increments('Sighting_id');
            $table->integer('User_id')->unsigned();
            $table->foreign('User_id')
                ->references('User_id')->on('users')
                ->onDelete('cascade');
            $table->string('Sighting_date');
            $table->string('Sighting_time');
            $table->string('Sighting_other');
            $table->string('Sighting_address');
            $table->string('Sighting_picture');
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
        Schema::dropIfExists('sightings');
    }
}
