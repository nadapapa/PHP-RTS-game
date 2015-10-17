<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('city');
            $table->integer('slot01');
            $table->integer('slot02');
            $table->integer('slot03');
            $table->integer('slot04');
            $table->integer('slot05');
            $table->integer('slot06');
            $table->integer('slot07');
            $table->integer('slot08');
            $table->integer('slot09');
            $table->integer('slot10');
            $table->integer('slot11');
            $table->integer('slot12');
            $table->integer('slot13');
            $table->integer('slot14');
            $table->integer('slot15');
            $table->integer('slot16');
            $table->integer('slot17');
            $table->integer('slot18');
            $table->integer('slot19');
            $table->integer('slot20');
            $table->integer('slot21');
            $table->integer('slot22');
            $table->integer('slot23');
            $table->integer('slot24');
            $table->integer('slot25');

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
