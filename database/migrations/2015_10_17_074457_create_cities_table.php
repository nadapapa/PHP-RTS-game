<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->boolean('capital');
            $table->string('name')->unique();

            $table->integer('owner')->unsigned();

            $table->integer('level')->default(1);
            $table->integer('nation');

            $table->integer('building_slots')->unsigned();

            $table->integer('hex_id')->unsigned();

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
        Schema::drop('cities');
    }
}
