<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusMaintenance extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bus_maintenance', function (Blueprint $table) {
      $table->string('plat_nomor');
      $table->timestamps();
      $table->string('token');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('bus_maintenance');
  }
}
