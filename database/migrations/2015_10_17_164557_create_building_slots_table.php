<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateBuildingSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_slots', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('city_id')->unsigned();

            $table->integer('wall')->unsigned();

            $table->integer('slot1')->unsigned();
            $table->integer('slot2')->unsigned();
            $table->integer('slot3')->unsigned();
            $table->integer('slot4')->unsigned();
            $table->integer('slot5')->unsigned();
            $table->integer('slot6')->unsigned();
            $table->integer('slot7')->unsigned();
            $table->integer('slot8')->unsigned();
            $table->integer('slot9')->unsigned();
            $table->integer('slot10')->unsigned();
            $table->integer('slot11')->unsigned();
            $table->integer('slot12')->unsigned();
            $table->integer('slot13')->unsigned();
            $table->integer('slot14')->unsigned();
            $table->integer('slot15')->unsigned();
            $table->integer('slot16')->unsigned();
            $table->integer('slot17')->unsigned();
            $table->integer('slot18')->unsigned();
            $table->integer('slot19')->unsigned();
            $table->integer('slot20')->unsigned();
            $table->integer('slot21')->unsigned();
            $table->integer('slot22')->unsigned();
            $table->integer('slot23')->unsigned();
            $table->integer('slot24')->unsigned();
            $table->integer('slot25')->unsigned();

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
        Schema::drop('building_slots');
    }
}
