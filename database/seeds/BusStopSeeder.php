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
    DB::table('bus_stop')->delete();

    DB::unprepared('ALTER TABLE bus_stop AUTO_INCREMENT = 1');

    DB::table('bus_stop')->insert([
        'nama_halte' => 'Halte Prambanan',
        'lokasi_halte' => 'Terminal Prambanan, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.75569444444444',
        'longitude' => '110.489805555556'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (KR 1)',
        'lokasi_halte' => 'Jl. Raya Yogya-Solo, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78175',
        'longitude' => '110.450583333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE BANDARA ADISUTJIPTO',
        'lokasi_halte' => 'Adisutjipto Airport, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78458333333333',
        'longitude' => '110.436361111111'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (JAYAKARTA)',
        'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78341666666667',
        'longitude' => '110.419333333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (JANTI FLYOVER)',
        'lokasi_halte' => 'Jl. Janti, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78575',
        'longitude' => '110.410444444444'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (JOGJA BISNIS)',
        'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78336111111111',
        'longitude' => '110.40175'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (GEDUNG WANITA)',
        'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78322222222222',
        'longitude' => '110.39275'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE URIP SUMOHARJO',
        'lokasi_halte' => 'Jl. Urip Sumoharjo, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78308333333333',
        'longitude' => '110.386083333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE SUDIRMAN 1',
        'lokasi_halte' => 'Jl. Jend. Sudirman, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78302777777778',
        'longitude' => '110.378'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE SUDIRMAN 2',
        'lokasi_halte' => 'Jl. Jend. Sudirman, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78302777777778',
        'longitude' => '110.3695'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE MANGKUBUMI 1',
        'lokasi_halte' => 'Jl. P. Mangkubumi, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78475',
        'longitude' => '110.366833333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE MANGKUBUMI 2',
        'lokasi_halte' => 'Jl. P. Mangkubumi, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78763888888889',
        'longitude' => '110.366416666667'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE MALIOBORO 1',
        'lokasi_halte' => 'Jl. Malioboro, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.79077777777778',
        'longitude' => '110.366027777778'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE MALIOBORO 2',
        'lokasi_halte' => 'Jl. Malioboro, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.79519444444444',
        'longitude' => '110.365527777778'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE AHMAD YANI',
        'lokasi_halte' => 'Jl. Jend. Ahmad Yani, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.79991666666667',
        'longitude' => '110.364944444444'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE SENOPATI 2',
        'lokasi_halte' => 'Jl. Senopati, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.80141666666667',
        'longitude' => '110.367583333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE PURO PAKUALAMAN',
        'lokasi_halte' => 'Jl. Sultan Agung, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.80163888888889',
        'longitude' => '110.37575'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE KUSUMANEGARA 1',
        'lokasi_halte' => 'Jl. Kusumanegara, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.80183333333333',
        'longitude' => '110.383472222222'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE KUSUMANEGARA 3',
        'lokasi_halte' => 'Jl. Kusumanegara, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.80208333333333',
        'longitude' => '110.393055555556'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE KUSUMANEGARA (GEDUNG JUANG 45)',
        'lokasi_halte' => 'Jl. Kusumanegara, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.80225',
        'longitude' => '110.399916666667'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE GEDONG KUNING (JEC)',
        'lokasi_halte' => 'Jl. Janti, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.79855555555556',
        'longitude' => '110.402833333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (JANTI)',
        'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78322222222222',
        'longitude' => '110.411583333333'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (ALFA)',
        'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78325',
        'longitude' => '110.419777777778'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (MAGUWO)',
        'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78336111111111',
        'longitude' => '110.430916666667'
    ]);

    //bandara adisucipto

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (KR 2)',
        'lokasi_halte' => 'Jl. Raya Yogya-Solo, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.78255555555556',
        'longitude' => '110.44875'
    ]);

    DB::table('bus_stop')->insert([
        'nama_halte' => 'HALTE JL. SOLO (KALASAN)',
        'lokasi_halte' => 'Jl. Raya Yogya-Solo, Yogyakarta, Indonesia',
        'last_bus' => '450',
        'latitude' => '-7.76991666666667',
        'longitude' => '110.468972222222'
    ]);
  }
}
