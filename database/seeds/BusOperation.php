<?php

use Illuminate\Database\Seeder;

class BusOperation extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('bus_operation')->insert([
      'plat_nomor' => '450',
      'rute_id' => '3A',
      'last_latitude' => '-7.76780555555556',
      'last_longitude' => '110.37425',
      'avg_speed' => '0.3898',
      'token' => 'bus450',
      'created_at' => \Carbon\Carbon::now(),
      'updated_at' => \Carbon\Carbon::now()
    ]);

    DB::table('bus_operation')->insert([
        'plat_nomor' => 'AB1234BA',
        'rute_id' => '3B',
        'last_latitude' => '-7.76780555555556',
        'last_longitude' => '110.37425',
        'avg_speed' => '0.3898',
        'token' => 'bus1234',
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now()
    ]);
  }
}
