<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class DumpGPSSeeder extends CsvSeeder
{
  public function __construct()
  {
    $this->table = 'dump_gps';
    $this->filename = base_path().'/database/seeds/csv/dump_gps.csv';
    $this->offset_rows = 1;
    $this->mapping = [
      1 => 'dump_id',
      3 => 'latitude',
      4 => 'longitude',
      5 => 'avg_speed'
    ];
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Recommended when importing larger CSVs
    DB::disableQueryLog();

    // Uncomment the below to wipe the table clean before populating
    DB::table($this->table)->truncate();

    parent::run();
  }
}
