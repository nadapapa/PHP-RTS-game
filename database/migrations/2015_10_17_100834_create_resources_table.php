<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('city')->unsigned();

            $table->integer('population')->unsigned()->default(100);
            $table->integer('workers')->unsigned()->default(5);
            $table->integer('settlers')->unsigned();

            $table->integer('iron')->unsigned()->default(100);
            $table->integer('stone')->unsigned()->default(100);
            $table->integer('lumber')->unsigned()->default(100);
            $table->integer('food')->unsigned()->default(100);

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
        Schema::drop('resources');
    }
}
