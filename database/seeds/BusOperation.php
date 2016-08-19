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
    DB::table('bus_operation')->delete();

    DB::unprepared('ALTER TABLE bus_operation AUTO_INCREMENT = 1');

    DB::table('bus_operation')->insert([
      'plat_nomor' => '450',
      'rute_id' => '3A',
      'last_latitude' => '-7.76780555555556',
      'last_longitude' => '110.37425',
      'avg_speed' => '0.3898',
      'token' => 'bus450',
      'created_at' => \Carbon\Carbon::now(),
      'updated_at' => \Carbon\Carbon::now(),
      'device_id' => 'qtRtIKQtwIX4Mr3HBzoC2CgqzWHkRAIZPwXVCo3MuMSQbi5tzn'
    ]);

    DB::table('bus_operation')->insert([
        'plat_nomor' => 'AB1234BA',
        'rute_id' => '3B',
        'last_latitude' => '-7.76780555555556',
        'last_longitude' => '110.37425',
        'avg_speed' => '0.3898',
        'token' => 'bus1234',
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
        'device_id' => 'ugFtUVYvuO6bn8EcruVWZzpXaroSlbjf6gG9GCMgouCGwxAZIZ'
    ]);
	  
	  DB::table('bus_operation')->insert([
		    'plat_nomor'  => 'AB9181GI',
			  'rute_id'     => '1A',
			  'token'       => 'bus9181',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'h56ww4r8kt49vuOey5hrrrruVWXaroSlrtrG9GCMgouy5y5yr'
	  ]);
	  
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB7529LB',
			  'rute_id'     => '1A',
			  'token'       => '3875115bac',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	  
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB4256KL',
			  'rute_id'     => '1B',
			  'token'       => 'bus4256',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB6258PO',
			  'rute_id'     => '1B',
			  'token'       => 'bus6258',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB5758MP',
			  'rute_id'     => '2A',
			  'token'       => 'bus5758',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB9078MP',
			  'rute_id'     => '2A',
			  'token'       => 'bus9078',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB7526KL',
			  'rute_id'     => '2B',
			  'token'       => 'bus7526',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB3197YI',
			  'rute_id'     => '2B',
			  'token'       => 'bus3197',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB4285ZA',
			  'rute_id'     => '3A',
			  'token'       => 'bus4285',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
	
	  DB::table('bus_operation')->insert([
			  'plat_nomor'  => 'AB6829BV',
			  'rute_id'     => '3B',
			  'token'       => 'bus6829',
			  'created_at'  => \Carbon\Carbon::now(),
			  'updated_at'  => \Carbon\Carbon::now(),
			  'device_id'   => 'J2DV5c6xUzkB9pEGkxfFF7Vh15HAtzMgeMV9LJmlrCSc07kApa'
	  ]);
  }
}
