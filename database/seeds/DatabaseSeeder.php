<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    $this->call(BusStopSeeder::class);
    $this->call(BusStopHistorySeeder::class);
    $this->call(BusOperation::class);
    $this->call(BusRouteSeeder::class);
    $this->call(InfoLiveSeeder::class);
    $this->call(UserTableSeeder::class);
    $this->call(DriverProfile::class);
    $this->call(SpeedViolationSeeder::class);
    Model::reguard();
  }
}
