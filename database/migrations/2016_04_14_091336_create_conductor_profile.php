<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConductorProfile extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('conductor_profile', function (Blueprint $table) {
      $table->string('conductor_id');
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
    Schema::drop('conductor_profile');
  }
}
