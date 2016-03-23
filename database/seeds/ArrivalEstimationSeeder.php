<?php

use Illuminate\Database\Seeder;

class ArrivalEstimationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('arrival_estimation')->insert([
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
        'halte_id_tujuan' => 1,
        'halte_id_asal' => 2,
        'rute_id' => '3A',
        'plat_nomor' => '450',
        'waktu_kedatangan' => 2500,
        'jarak' => 200
    ]);

    DB::table('arrival_estimation')->insert([
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
        'halte_id_tujuan' => 3,
        'halte_id_asal' => 1,
        'rute_id' => '3B',
        'plat_nomor' => '450',
        'waktu_kedatangan' => 1500,
        'jarak' => 100
    ]);
  }
}
