<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusStopHistoryMigration extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bus_stop_history', function (Blueprint $table) {
      $table->increments('arrival_history');
      $table->string('plat_nomor');
      $table->integer('halte_id')->unsigned();
      $table->string('rute_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('bus_stop_history');
  }
}
