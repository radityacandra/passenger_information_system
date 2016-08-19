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


	  //rute 1B
	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 3,
			  'urutan'    => 1
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 4,
			  'urutan'    => 2
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 22,
			  'urutan'    => 3
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 27,
			  'urutan'    => 4
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 28,
			  'urutan'    => 5
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 5,
			  'urutan'    => 6
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 29,
			  'urutan'    => 7
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 30,
			  'urutan'    => 8
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 31,
			  'urutan'    => 9
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 32,
			  'urutan'    => 10
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 33,
			  'urutan'    => 11
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 34,
			  'urutan'    => 12
	  ]);

	  DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 35,
			  'urutan'    => 13
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 36,
			  'urutan'    => 14
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 37,
			  'urutan'    => 15
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 38,
			  'urutan'    => 16
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 39,
			  'urutan'    => 17
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 40,
			  'urutan'    => 18
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 41,
			  'urutan'    => 19
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 42,
			  'urutan'    => 20
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 5,
			  'urutan'    => 21
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 22,
			  'urutan'    => 22
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 23,
			  'urutan'    => 23
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '1B',
			  'halte_id'  => 24,
			  'urutan'    => 24
	  ]);

    //rute 2A
    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 43,
			  'urutan'    => 1
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 44,
			  'urutan'    => 2
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 45,
			  'urutan'    => 3
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 11,
			  'urutan'    => 4
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 12,
			  'urutan'    => 5
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 13,
			  'urutan'    => 6
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 14,
			  'urutan'    => 7
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 15,
			  'urutan'    => 8
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 16,
			  'urutan'    => 9
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 46,
			  'urutan'    => 10
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 47,
			  'urutan'    => 11
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 48,
			  'urutan'    => 12
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 49,
			  'urutan'    => 13
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 50,
			  'urutan'    => 14
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 31,
			  'urutan'    => 15
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 32,
			  'urutan'    => 16
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 51,
			  'urutan'    => 17
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 52,
			  'urutan'    => 18
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 9,
			  'urutan'    => 19
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 38,
			  'urutan'    => 20
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 39,
			  'urutan'    => 21
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 40,
			  'urutan'    => 22
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 53,
			  'urutan'    => 23
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 54,
			  'urutan'    => 24
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 55,
			  'urutan'    => 25
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 56,
			  'urutan'    => 26
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2A',
			  'halte_id'  => 57,
			  'urutan'    => 27
	  ]);

    //rute 2B
    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 43,
			  'urutan'    => 1
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 44,
			  'urutan'    => 2
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 58,
			  'urutan'    => 3
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 55,
			  'urutan'    => 4
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 59,
			  'urutan'    => 5
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 60,
			  'urutan'    => 6
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 61,
			  'urutan'    => 7
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 62,
			  'urutan'    => 8
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 63,
			  'urutan'    => 9
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 52,
			  'urutan'    => 10
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 64,
			  'urutan'    => 11
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 19,
			  'urutan'    => 12
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 20,
			  'urutan'    => 13
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 65,
			  'urutan'    => 14
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 66,
			  'urutan'    => 15
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 67,
			  'urutan'    => 16
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 68,
			  'urutan'    => 17
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 69,
			  'urutan'    => 18
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 35,
			  'urutan'    => 19
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 70,
			  'urutan'    => 20
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 71,
			  'urutan'    => 21
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 72,
			  'urutan'    => 22
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 73,
			  'urutan'    => 23
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 36,
			  'urutan'    => 24
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 74,
			  'urutan'    => 25
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 75,
			  'urutan'    => 26
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '2B',
			  'halte_id'  => 57,
			  'urutan'    => 27
	  ]);

    //rute 3A
    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 76,
			  'urutan'    => 1
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 77,
			  'urutan'    => 2
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 50,
			  'urutan'    => 3
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 21,
			  'urutan'    => 4
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 22,
			  'urutan'    => 5
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 23,
			  'urutan'    => 6
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 24,
			  'urutan'    => 7
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 3,
			  'urutan'    => 8
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 78,
			  'urutan'    => 9
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 79,
			  'urutan'    => 10
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 80,
			  'urutan'    => 11
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 55,
			  'urutan'    => 12
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 56,
			  'urutan'    => 13
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 81,
			  'urutan'    => 14
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 82,
			  'urutan'    => 15
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 63,
			  'urutan'    => 16
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 52,
			  'urutan'    => 17
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 83,
			  'urutan'    => 18
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 10,
			  'urutan'    => 19
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 84,
			  'urutan'    => 20
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 85,
			  'urutan'    => 21
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 86,
			  'urutan'    => 22
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 13,
			  'urutan'    => 23
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 24,
			  'urutan'    => 24
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 15,
			  'urutan'    => 25
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 70,
			  'urutan'    => 26
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 71,
			  'urutan'    => 27
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 87,
			  'urutan'    => 28
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 47,
			  'urutan'    => 29
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 88,
			  'urutan'    => 30
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 89,
			  'urutan'    => 31
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3A',
			  'halte_id'  => 90,
			  'urutan'    => 32
	  ]);

    //rute 3B
    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 76,
			  'urutan'    => 1
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 91,
			  'urutan'    => 2
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 92,
			  'urutan'    => 3
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 93,
			  'urutan'    => 4
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 68,
			  'urutan'    => 5
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 94,
			  'urutan'    => 6
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 95,
			  'urutan'    => 7
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 71,
			  'urutan'    => 8
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 96,
			  'urutan'    => 9
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 36,
			  'urutan'    => 10
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 37,
			  'urutan'    => 11
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 38,
			  'urutan'    => 12
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 97,
			  'urutan'    => 13
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 98,
			  'urutan'    => 14
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 58,
			  'urutan'    => 15
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 55,
			  'urutan'    => 16
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 99,
			  'urutan'    => 17
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 100,
			  'urutan'    => 18
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 101,
			  'urutan'    => 19
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 102,
			  'urutan'    => 20
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 24,
			  'urutan'    => 21
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 3,
			  'urutan'    => 22
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 4,
			  'urutan'    => 23
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 5,
			  'urutan'    => 24
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 29,
			  'urutan'    => 25
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 30,
			  'urutan'    => 26
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 65,
			  'urutan'    => 27
	  ]);

    DB::table('bus_route')->insert([
			  'rute_id'   => '3B',
			  'halte_id'  => 103,
			  'urutan'    => 28
	  ]);
  }
}
