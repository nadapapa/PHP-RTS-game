<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->integer('city')->unsigned();
            $table->integer('slot')->unsigned();

            $table->integer('nation');
            $table->integer('type');
            $table->integer('level')->default(1);
            $table->integer('worker');
            $table->integer('health')->default('100');

            $table->timestamps();
            $table->timestamp('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('buildings');
    }
}
