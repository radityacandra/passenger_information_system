<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeedback extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_feedback', function (Blueprint $table) {
      $table->increments('feedback_id');
      $table->timestamps();
      $table->integer('user_id');
      $table->integer('satisfaction');
      $table->text('complaint');
      $table->string('directed_to_bus');
      $table->integer('directed_to_bus_stop');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('user_feedback');
  }
}
