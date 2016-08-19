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
		DB::table('route')->delete();

    DB::unprepared('ALTER TABLE route AUTO_INCREMENT = 1');

		Route::create([
				'rute_id' => '1A',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Terminal Prambanan, Bandara Adisutjipto, Stasiun Tugu, Malioboro, JEC",
		]);

		Route::create([
				'rute_id' => '1B',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Bandara Adisutjipto, JEC, km 0, UGM) dan Rute 3B (Terminal Giwangan, UGM, Ringroad Utara, Bandara Adisutjipto, Kotagede",
		]);

		Route::create([
				'rute_id' => '2A',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Terminal Jombor, Malioboro, Kotagede, Kridosono, UGM, Terminal Condongcatur",
		]);

		Route::create([
				'rute_id' => '2B',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Terminal Jombor, Terminal Condongcatur, UGM, Kridosono, Kotagede, km 0",
		]);

		Route::create([
				'rute_id' => '3A',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Terminal Giwangan, Kotagede, Bandara Adisutjipto, Ringroad Utara, UGM, Malioboro",
		]);

		Route::create([
				'rute_id' => '3B',
				'created_at'  => \Carbon\Carbon::now(),
				'updated_at'  => \Carbon\Carbon::now(),
				'deskripsi'   => "Terminal Giwangan, UGM, Ringroad Utara, Bandara Adisutjipto, Kotagede",
		]);
	}
}
