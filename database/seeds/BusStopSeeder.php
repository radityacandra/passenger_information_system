<?php

use Illuminate\Database\Seeder;

class BusStopSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('bus_stop')->insert([
        'nama_halte' => 'Cik Di Tiro',
        'lokasi_halte' => 'Jalan Cik Di Tiro, Koperasi Mahasiswa UGM Yogyakarta',
        'last_bus' => '450',
        'latitude' => '-7.76780555555556',
        'longitude' => '110.37425'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'Jalan Kesehatan',
        'lokasi_halte' => 'Jalan Kesehatan, Depan Fakultas Kedokteran UGM, Seberang RS. Karyadi, Yogyakarta',
        'last_bus' => '450',
        'latitude' => '-7.77427777777778',
        'longitude' => '110.375138888889'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'Jalan Kaliurang',
        'lokasi_halte' => 'Jalan Kaliurang KM 5 depan Ayam Goreng Hayam Wuruk, Yogyakarta',
        'last_bus' => '450',
        'latitude' => '-7.77427777777778',
        'longitude' => '110.375138888889'
    ]);
  }
}
