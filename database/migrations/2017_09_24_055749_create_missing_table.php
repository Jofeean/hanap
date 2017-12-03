<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missings', function (Blueprint $table) {
            $table->increments('Missing_id');
            $table->integer('User_id')->unsigned();
            $table->foreign('User_id')
                ->references('User_id')->on('users')
                ->onDelete('cascade');

            $table->string('Missing_fname');
            $table->string('Missing_mname')->nullable();
            $table->string('Missing_lname');
            $table->string('Missing_nname')->nullable();
            $table->string('Missing_gender');
            $table->string('Missing_bday');

            $table->string('Missing_hcolor');
            $table->string('Missing_height')->nullable();
            $table->string('Missing_eyecolor');
            $table->string('Missing_hair')->nullable();
            $table->string('Missing_weight')->nullabale();
            $table->string('Missing_bodytype');
            $table->string('Missing_bodyhair');
            $table->string('Missing_facialhair');

            $table->string('Missing_dodis');
            $table->string('Missing_disaddress');
            $table->string('Missing_discity');

            $table->string('Missing_bodymarkings');
            $table->string('Missing_clothes');
            $table->string('Missing_other');

            $table->string('Missing_foundate')->nullable();

            $table->string('Missing_status')->default('0');
            $table->string('Missing_faceid');
            $table->string('Missing_picture');
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
        Schema::dropIfExists('missings');
    }
}
