<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_operation', function (Blueprint $table) {
            $table->string('plat_nomor');
            $table->string('rute_id');
            $table->string('last_latitude');
            $table->string('last_longitude');
            $table->string('avg_speed');

            $table->primary('plat_nomor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bus_operation');
    }
}
