<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignBusOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_operation', function (Blueprint $table) {
            $table->foreign('rute_id')->references('rute_id')->on('bus_route');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_operation', function (Blueprint $table) {
            $table->dropForeign('bus_operation_rute_id_foreign');
        });
    }
}
