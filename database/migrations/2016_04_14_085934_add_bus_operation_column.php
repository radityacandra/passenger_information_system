<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusOperationColumn extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('bus_operation', function (Blueprint $table) {
      $table->string('driver_id');
      $table->string('conductor_id');
      $table->string('device_status');
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
      $table->dropColumn('driver_id');
      $table->dropColumn('conductor_id');
      $table->dropColumn('device_status');
    });
  }
}
