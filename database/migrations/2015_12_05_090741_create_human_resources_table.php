<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanResourcesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_resources', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('city')->unsigned();

            $table->integer('population')->unsigned()->default(10);
            $table->integer('workers')->unsigned()->default(5);
            $table->integer('settlers')->unsigned();

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
        Schema::drop('human_resources');
    }

}
