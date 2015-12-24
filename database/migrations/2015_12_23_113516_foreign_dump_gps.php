<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignDumpGps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dump_gps', function (Blueprint $table) {
            $table->foreign('route_id')->references('rute_id')->on('bus_route');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dump_gps', function (Blueprint $table) {
            $table->dropForeign('dump_gps_route_id_foreign');
        });
    }
}
