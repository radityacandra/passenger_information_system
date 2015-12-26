<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalEstimation extends Migration
{
    /**
     * Run the migrations.
     * jarak dalam satuan meter, waktu kedatangan dalam satuan menit
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrival_estimation', function (Blueprint $table) {
            $table->string('arrival_code');
            $table->timestamps();
            $table->integer('halte_id_tujuan')->unsigned();
            $table->integer('halte_id_asal')->unsigned();
            $table->string('rute_id');
            $table->string('plat_nomor');
            $table->integer('waktu_kedatangan');
            $table->integer('jarak');

            $table->primary('arrival_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('arrival_estimation');
    }
}
