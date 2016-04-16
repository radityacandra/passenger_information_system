<?php

use Illuminate\Database\Seeder;

class SpeedViolationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('speed_violation')->delete();

    DB::unprepared('ALTER TABLE speed_violation AUTO_INCREMENT = 1');

    DB::table('speed_violation')->insert([
      'created_at'  => \Carbon\Carbon::now(),
      'updated_at'  => \Carbon\Carbon::now(),
      'plat_nomor'  => 'AB4567BA',
      'speed_violation' => '65',
      'on_violation'    => true,
      'count_violation' => 1
    ]);
  }
}
