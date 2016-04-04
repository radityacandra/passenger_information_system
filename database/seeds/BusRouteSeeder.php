<?php

use Illuminate\Database\Seeder;

class BusRouteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('bus_route')->delete();

    DB::unprepared('ALTER TABLE bus_route AUTO_INCREMENT = 1');

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 1,
        'urutan'    => 1
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 2,
        'urutan'    => 2
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 3,
        'urutan'    => 3
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 4,
        'urutan'    => 4
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 5,
        'urutan'    => 5
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 6,
        'urutan'    => 6
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 7,
        'urutan'    => 7
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 8,
        'urutan'    => 8
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 9,
        'urutan'    => 9
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 10,
        'urutan'    => 10
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 11,
        'urutan'    => 11
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 12,
        'urutan'    => 12
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 13,
        'urutan'    => 13
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 14,
        'urutan'    => 14
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 15,
        'urutan'    => 15
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 16,
        'urutan'    => 16
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 17,
        'urutan'    => 17
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 18,
        'urutan'    => 18
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 19,
        'urutan'    => 19
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 20,
        'urutan'    => 20
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 21,
        'urutan'    => 21
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 22,
        'urutan'    => 22
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 23,
        'urutan'    => 23
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 24,
        'urutan'    => 24
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 6,
        'urutan'    => 25
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 25,
        'urutan'    => 26
    ]);

    DB::table('bus_route')->insert([
        'rute_id'   => '1A',
        'halte_id'  => 26,
        'urutan'    => 27
    ]);
  }
}
