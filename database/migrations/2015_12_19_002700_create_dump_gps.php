<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDumpGps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dump_gps', function (Blueprint $table) {
            $table->increments('dump_id');
            $table->timestamps();
            $table->string('route_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('avg_speed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dump_gps');
    }
}
