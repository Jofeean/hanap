<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('Match_id');
            $table->integer('User_id')->unsigned();
            $table->foreign('User_id')
                ->references('User_id')->on('users')
                ->onDelete('cascade');
            $table->integer('Missing_id')->unsigned();
            $table->foreign('Missing_id')
                ->references('Missing_id')->on('missings')
                ->onDelete('cascade');
            $table->integer('Sighting_id')->unsigned();
            $table->foreign('Sighting_id')
                ->references('Sighting_id')->on('sightings')
                ->onDelete('cascade');
            $table->string('Match_confidence');
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
        Schema::dropIfExists('matches');
    }
}
