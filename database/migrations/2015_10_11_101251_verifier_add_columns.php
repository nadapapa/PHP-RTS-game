<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class VerifierAddColumns extends Migration
{
    /**
    * Run the migrations.
    *
    * @return  void
    */
    public function up()
    {
            Schema::table('users', function(Blueprint $table)
        {
            $table->string('verification_code')->nullable();
            $table->boolean('verified');
        });
        }

    public function down()
    {
            Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('verification_code');
            $table->dropColumn('verified');
        });
        }
}
