<?php

use Illuminate\Database\Seeder;

class DriverProfile extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $mulaiBekerja = '2012-12-12';
    DB::table('driver_profile')->insert([
      'driver_id'   => 'sopsup1',
      'created_at'  => \Carbon\Carbon::now(),
      'updated_at'  => \Carbon\Carbon::now(),
      'full_name'   => 'supardi',
      'phone_number'=> '085727123456',
      'address'     => 'Jalan Serba Guna, Kotabaru, Daerah Istimewa Yogyakarta',
      'mulai_bekerja' => $mulaiBekerja
    ]);

    $mulaiBekerja = '2012-12-13';
    DB::table('driver_profile')->insert([
        'driver_id'   => 'sopmar1',
        'created_at'  => \Carbon\Carbon::now(),
        'updated_at'  => \Carbon\Carbon::now(),
        'full_name'   => 'maryadi dela cozta',
        'phone_number'=> '085727126416',
        'address'     => 'Jalan Serba Guna, Kotalama, Daerah Istimewa Yogyakarta',
        'mulai_bekerja' => $mulaiBekerja
    ]);

    $mulaiBekerja = '2012-05-23';
    DB::table('driver_profile')->insert([
        'driver_id'   => 'sopsuk1',
        'created_at'  => \Carbon\Carbon::now(),
        'updated_at'  => \Carbon\Carbon::now(),
        'full_name'   => 'sukardiman',
        'phone_number'=> '085727946756',
        'address'     => 'Jalan Serba Guna, Kotaku, Daerah Istimewa Yogyakarta',
        'mulai_bekerja' => $mulaiBekerja
    ]);
  }
}
