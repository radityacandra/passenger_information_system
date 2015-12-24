<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignBusRoute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_route', function (Blueprint $table) {
            $table->foreign('halte_id')->references('halte_id')->on('bus_stop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_route', function (Blueprint $table) {
            $table->dropForeign('bus_route_halte_id_foreign');
        });
    }
}
