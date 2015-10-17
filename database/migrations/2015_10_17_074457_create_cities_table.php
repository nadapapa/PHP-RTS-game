<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->boolean('capital');
            $table->string('name');
            $table->integer('owner');
            $table->integer('population')->default(100);
            $table->integer('workers');
            $table->integer('iron')->default(100);
            $table->integer('stone')->default(100);
            $table->integer('lumber')->default(100);
            $table->integer('food')->default(100);
            $table->integer('level')->default(1);
            $table->integer('nation');
            $table->integer('slots')->default(10);
            $table->integer('hex_id');
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
