<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusOperation3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_operation', function (Blueprint $table) {
            $table->integer('iterasi_arrival_check');
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
            $table->dropColumn('iterasi_arrival_check');
        });
    }
}
