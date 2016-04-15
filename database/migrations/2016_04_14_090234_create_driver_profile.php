<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverProfile extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('driver_profile', function (Blueprint $table) {
      $table->string('driver_id');
      $table->timestamps();
      $table->string('full_name');
      $table->string('phone_number');
      $table->string('address');
      $table->date('mulai_bekerja');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('driver_profile');
  }
}
