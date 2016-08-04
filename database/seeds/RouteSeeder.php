<?php

use Illuminate\Database\Seeder;
use App\Route;

class RouteSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Route::create([
				'rute_id' => '1A',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Halte Kusumanegara - Mall Ambarukmo - Jembatan Janti - JEC - Malioboro - Nol Kilometer",
		]);
	}
}
