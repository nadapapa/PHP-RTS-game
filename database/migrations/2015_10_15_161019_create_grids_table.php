<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateGridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('x');
            $table->integer('y');
            $table->integer('layer1');
            $table->integer('layer2');
            $table->integer('layer3');
            $table->integer('layer4');
            $table->integer('layer5');

            $table->integer('owner')->unsigned();

            $table->integer('city')->unsigned();
            $table->integer('army_id');

        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grid');
    }
}
