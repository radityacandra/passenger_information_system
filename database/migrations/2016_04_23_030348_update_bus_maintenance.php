<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBusMaintenance extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('bus_maintenance', function (Blueprint $table) {
      $table->text('diagnosis');
      $table->integer('pic_id');
    });

    Schema::table('bus_operation', function (Blueprint $table) {
      $table->dateTime('last_maintenance');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('bus_maintenance', function (Blueprint $table) {
      $table->dropColumn('diagnosis');
      $table->dropColumn('pic_id');
    });

    Schema::table('bus_operation', function (Blueprint $table) {
      $table->dropColumn('last_maintenance');
    });
  }
}
