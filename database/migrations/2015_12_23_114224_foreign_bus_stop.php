<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignBusStop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_stop', function (Blueprint $table) {
            $table->foreign('last_bus')->references('plat_nomor')->on('bus_operation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_stop', function (Blueprint $table) {
            $table->dropForeign('bus_stop_last_bus_foreign');
        });
    }
}
