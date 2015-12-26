<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDumpGpsPlatNomor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dump_gps', function (Blueprint $table) {
            $table->string('plat_nomor');
        });

        Schema::table('dump_gps', function (Blueprint $table) {
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
        Schema::table('dump_gps', function (Blueprint $table) {
            $table->dropForeign('dump_gps_plat_nomor_foreign');
            $table->dropColumn('plat_nomor');
        });
    }
}