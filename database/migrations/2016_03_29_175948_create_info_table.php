<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_live', function (Blueprint $table) {
      $table->increments('news_id');
      $table->timestamps();
      $table->string('judul');
      $table->text('content');
      $table->string('penulis');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('info_live');
  }
}
