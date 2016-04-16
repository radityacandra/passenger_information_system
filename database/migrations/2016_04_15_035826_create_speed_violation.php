<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeedViolation extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('speed_violation', function (Blueprint $table) {
      $table->increments('violation_id');
      $table->timestamps();
      $table->string('plat_nomor');
      $table->string('speed_violation');
      $table->boolean('on_violation');
      $table->integer('count_violation');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('speed_violation');
  }
}
