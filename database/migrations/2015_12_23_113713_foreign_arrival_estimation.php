<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignArrivalEstimation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arrival_estimation', function (Blueprint $table) {
            $table->foreign('halte_id_tujuan')->references('halte_id')->on('bus_stop');
            $table->foreign('halte_id_asal')->references('halte_id')->on('bus_stop');
            //$table->foreign('rute_id')->references('rute_id')->on('bus_route');
            $table->foreign('plat_nomor')->references('plat_nomor')->on('bus_operation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arrival_estimation', function (Blueprint $table) {
            $table->dropForeign('arrival_estimation_halte_id_tujuan_foreign');
            $table->dropForeign('arrival_estimation_halte_id_asal_foreign');
            //$table->dropForeign('arrival_estimation_rute_id_foreign');
            $table->dropForeign('arrival_estimation_plat_nomor_foreign');
        });
    }
}
