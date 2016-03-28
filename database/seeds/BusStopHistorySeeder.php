<?php

use Illuminate\Database\Seeder;

class BusStopHistorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('bus_stop_history')->delete();

    DB::table('bus_stop_history')->insert([
        'plat_nomor'  => 'AB1234BA',
        'halte_id'    => 4,
        'rute_id'     => '1A'
    ]);

    DB::table('bus_stop_history')->insert([
        'plat_nomor'  => 'AB1234BA',
        'halte_id'    => 5,
        'rute_id'     => '1A'
    ]);
  }
}
