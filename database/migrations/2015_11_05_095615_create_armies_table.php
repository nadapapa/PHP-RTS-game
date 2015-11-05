<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArmiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armies', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('unit1');
            $table->integer('unit2');
            $table->integer('unit3');
            $table->integer('unit4');
            $table->integer('unit5');
            $table->integer('unit6');
            $table->integer('unit7');

            $table->integer('user_id');
            $table->integer('current_hex_id');
            $table->integer('destination_hex_id');
            $table->integer('task_id');

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
        Schema::drop('armies');
    }

}
