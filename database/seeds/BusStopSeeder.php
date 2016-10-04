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

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE J-WALK',
			  'lokasi_halte' => 'Jl. Babarsari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.779425',
			  'longitude' => '110.414702777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PORTABLE JL. BABARSARI',
			  'lokasi_halte' => 'Jl. Babarsari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77399444444444',
			  'longitude' => '110.412127777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RS. AU DR.S. HARDJOLUKITO',
			  'lokasi_halte' => 'Jl. Janti, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79730555555556',
			  'longitude' => '110.410083333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE GEDONG KUNING (WONOCATUR)',
			  'lokasi_halte' => 'Jl. Janti, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79861111111111',
			  'longitude' => '110.406416666667'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KUSUMANEGARA (GEMBIRALOKA)',
			  'lokasi_halte' => 'Jl. Kusumanegara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80227777777778',
			  'longitude' => '110.398805555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KUSUMANEGARA 4',
			  'lokasi_halte' => 'Jl. Kusumanegara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80213888888889',
			  'longitude' => '110.393361111111'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KUSUMANEGARA 2',
			  'lokasi_halte' => 'Jl. Kusumanegara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80188888888889',
			  'longitude' => '110.382138888889'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE MUSEUM BIOLOGI',
			  'lokasi_halte' => 'Jl. Sultan Agung, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80166666666667',
			  'longitude' => '110.374194444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SENOPATI 1',
			  'lokasi_halte' => 'Jl. Senopati, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80152777777778',
			  'longitude' => '110.367'
	  ]);

    DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TENTARA PELAJAR 1',
			  'lokasi_halte' => 'Jl. Tentara Pelajar, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78658333333333',
			  'longitude' => '110.359916666667'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SUDIRMAN 3',
			  'lokasi_halte' => 'Jl. Jend. Sudirman, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78288888888889',
			  'longitude' => '110.368833333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE CIK DI TIRO 2',
			  'lokasi_halte' => 'Jl. Cik Di Tiro, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78122222222222',
			  'longitude' => '110.375194444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. COLOMBO (KOSUDGAMA)',
			  'lokasi_halte' => 'Jl. Terban, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77616666666667',
			  'longitude' => '110.378583333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. COLOMBO (UNY)',
			  'lokasi_halte' => 'Jl. Colombo, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77775',
			  'longitude' => '110.386722222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. SOLO (DEBRITO)',
			  'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78311111111111',
			  'longitude' => '110.393888888889'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. SOLO (AMBARUKMO)',
			  'lokasi_halte' => 'Jl. Laksda Adisucipto, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78319444444444',
			  'longitude' => '110.402361111111'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TERMINAL JOMBOR',
			  'lokasi_halte' => 'Terminal Jombor, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.74747222222222',
			  'longitude' => '110.361722222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (MONJALI 1)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.75047222222222',
			  'longitude' => '110.367583333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE AM SANGAJI 2',
			  'lokasi_halte' => 'Jl. AM Sangaji, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77575',
			  'longitude' => '110.367972222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KATAMSO 1',
			  'lokasi_halte' => 'Jl. Brigjend. Katamso, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80872222222222',
			  'longitude' => '110.369138888889'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SUGIONO 1',
			  'lokasi_halte' => 'Jl. Kolonel Sugiyono, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81477777777778',
			  'longitude' => '110.370027777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RSI HIDAYATULLAH',
			  'lokasi_halte' => 'Jl. Veteran, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81558333333333',
			  'longitude' => '110.38775'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE NGEKSIGONDO (DIKLAT PU)',
			  'lokasi_halte' => 'Jl. Ngeksigondo, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81905555555556',
			  'longitude' => '110.395083333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE GEDONG KUNING (DEP. KEHUTANAN)',
			  'lokasi_halte' => 'Jl. Gedong Kuning, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.8195',
			  'longitude' => '110.401166666667'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KENARI 1',
			  'lokasi_halte' => 'Jl. Gayam, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.7975',
			  'longitude' => '110.383194444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE YOS SUDARSO',
			  'lokasi_halte' => 'Jl. Laksda Yos Sudarso, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78727777777778',
			  'longitude' => '110.375305555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE UNY',
			  'lokasi_halte' => 'Jl. Gejayan (Jl. Affandi), Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77516666666667',
			  'longitude' => '110.389194444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SANTREN',
			  'lokasi_halte' => 'Jl. Gejayan (Jl. Affandi), Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76697222222222',
			  'longitude' => '110.391694444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TERMINAL CONDONGCATUR',
			  'lokasi_halte' => 'Terminal Condongcatur, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.75663888888889',
			  'longitude' => '110.395944444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (MANGGUNG)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.75805555555556',
			  'longitude' => '110.386388888889'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (MONJALI 2)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.75083333333333',
			  'longitude' => '110.36875'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KENTUNGAN',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.75527777777778',
			  'longitude' => '110.383861111111'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SUSTERAN NOVISIAT',
			  'lokasi_halte' => 'Jl. Gejayan (Jl. Affandi), Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76594444444444',
			  'longitude' => '110.392222222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SANATA DHARMA',
			  'lokasi_halte' => 'Jl. Gejayan (Jl. Affandi), Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77502777777778',
			  'longitude' => '110.389277777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. COLOMBO (SAMIRONO)',
			  'lokasi_halte' => 'Jl. Colombo, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77763888888889',
			  'longitude' => '110.3875'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. COLOMBO (PANTI RAPIH)',
			  'lokasi_halte' => 'Jl. Terban, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77619444444444',
			  'longitude' => '110.378194444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE CIK DI TIRO 1',
			  'lokasi_halte' => 'Jl. Cik Di Tiro, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78227777777778',
			  'longitude' => '110.375111111111'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KENARI 2',
			  'lokasi_halte' => 'Jl. Gayam, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79747222222222',
			  'longitude' => '110.383305555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE GEDONG KUNING (BANGUNTAPAN)',
			  'lokasi_halte' => 'Jl. Gedong Kuning, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80725',
			  'longitude' => '110.40225'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE NGEKSIGONDO (BASEN)',
			  'lokasi_halte' => 'Jl. Ngeksigondo, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81913888888889',
			  'longitude' => '110.395083333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PASAR SENI KERAJINAN YOGYAKARTA',
			  'lokasi_halte' => 'Jl. Veteran, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81622222222222',
			  'longitude' => '110.385972222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SUGIONO 2',
			  'lokasi_halte' => 'Jl. Kolonel Sugiyono, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81519444444444',
			  'longitude' => '110.371833333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KATAMSO 2',
			  'lokasi_halte' => 'Jl. Brigjend. Katamso, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80275',
			  'longitude' => '110.369194444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KHA DAHLAN 1',
			  'lokasi_halte' => 'Jl. KHA Dahlan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80127777777778',
			  'longitude' => '110.360083333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE NGABEAN',
			  'lokasi_halte' => 'Taman Parkir Ngabean, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80372222222222',
			  'longitude' => '110.35625'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE COKROAMINOTO (SMA 1)',
			  'lokasi_halte' => 'Jl. HOS Cokroaminoto, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79933333333333',
			  'longitude' => '110.352055555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SMPN 11',
			  'lokasi_halte' => 'Jl. HOS Cokroaminoto, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79294444444444',
			  'longitude' => '110.353416666667'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE AM SANGAJI 1',
			  'lokasi_halte' => 'Jl. AM Sangaji, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77730555555556',
			  'longitude' => '110.367694444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KARANGJATI',
			  'lokasi_halte' => 'Jl. Monjali, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76438888888889',
			  'longitude' => '110.369083333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE GIWANGAN',
			  'lokasi_halte' => 'Terminal Giwangan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.83348055277778',
			  'longitude' => '110.392108333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TEGAL GENDU 1',
			  'lokasi_halte' => 'Jl. Tegalgendu, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82602777777778',
			  'longitude' => '110.391777777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (DISNAKER)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76933333333333',
			  'longitude' => '110.431083333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (INSTIPER 2)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76452777777778',
			  'longitude' => '110.423611111111'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (UPN)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76061111111111',
			  'longitude' => '110.408'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE FK-UGM',
			  'lokasi_halte' => 'Jl. Kesehatan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76780555555556',
			  'longitude' => '110.37425'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. KALIURANG (KOPMA UGM)',
			  'lokasi_halte' => 'Jl. Persatuan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77427777777778',
			  'longitude' => '110.375138888889'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KOTABARU',
			  'lokasi_halte' => 'Jl. FM Noto, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78466666666667',
			  'longitude' => '110.371361111111'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE DIPONEGORO',
			  'lokasi_halte' => 'Jl. Diponegoro, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78291666666667',
			  'longitude' => '110.362527777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TENTARA PELAJAR 2',
			  'lokasi_halte' => 'Jl. Tentara Pelajar, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78716666666667',
			  'longitude' => '110.35975'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JLAGRAN',
			  'lokasi_halte' => 'Jl. Jlagran Lor, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.7895',
			  'longitude' => '110.360166666667'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE MT HARYONO 1',
			  'lokasi_halte' => 'Jl. Letnan Jenderal MT Haryono, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81319444444444',
			  'longitude' => '110.357333333333'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE LOWANU',
			  'lokasi_halte' => 'Jl. Lowanu, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81975',
			  'longitude' => '110.376444444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SOROGENEN',
			  'lokasi_halte' => 'Jl. Sorogenen, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82475',
			  'longitude' => '110.379222222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TEGAL TURI 1',
			  'lokasi_halte' => 'Jl. Tegal Turi, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82536111111111',
			  'longitude' => '110.387055555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TEGAL TURI 2',
			  'lokasi_halte' => 'Jl. Tegal Turi, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82541666666667',
			  'longitude' => '110.386944444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE NITIKAN',
			  'lokasi_halte' => 'Jl. Sorogenen, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82480555555555',
			  'longitude' => '110.379972222222'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PA MUHAMMADIYAH',
			  'lokasi_halte' => 'Jl. Lowanu, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81686111111111',
			  'longitude' => '110.376'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE MT HARYONO 2',
			  'lokasi_halte' => 'Jl. Letnan Jenderal MT Haryono, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81347222222222',
			  'longitude' => '110.358166666667'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TEJOKUSUMAN',
			  'lokasi_halte' => 'Jl. Kyai Haji Wahid Hasyim, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80794444444444',
			  'longitude' => '110.356'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE KHA DAHLAN 2',
			  'lokasi_halte' => 'Jl. KHA Dahlan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80119444444444',
			  'longitude' => '110.360555555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE JL. KALIURANG (PERTANIAN UGM)',
			  'lokasi_halte' => 'Jl. Persatuan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.7745',
			  'longitude' => '110.374944444444'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RSUP DR. SARDJITO',
			  'lokasi_halte' => 'Jl. Kesehatan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76952777777778',
			  'longitude' => '110.373555555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (JIH)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.75883333333333',
			  'longitude' => '110.403055555556'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (STIKES GUNA BANGSA)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76075',
			  'longitude' => '110.408888888889'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (INSTIPER 1)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.76425',
			  'longitude' => '110.4235'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE RING ROAD UTARA (BINAMARGA)',
			  'lokasi_halte' => 'Jl. Ring Road Utara, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.77444444444444',
			  'longitude' => '110.430777777778'
	  ]);

	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TEGAL GENDU 2',
			  'lokasi_halte' => 'Jl. Tegalgendu, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82586111111111',
			  'longitude' => '110.391333333333'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SMK MUHAMMADIYAH 3',
			  'lokasi_halte' => 'Jl. Pramuka, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.82261388888889',
			  'longitude' => '110.389658333333'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PORTABLE JL. MENTERI SUPENO 1',
			  'lokasi_halte' => 'Jl. Menteri Supeno, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81616111111111',
			  'longitude' => '110.379927775'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PORTABLE JL. TAMAN SISWA',
			  'lokasi_halte' => 'Jl. Taman Siswa, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81296110833333',
			  'longitude' => '110.376613886111'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE HAYAM WURUK',
			  'lokasi_halte' => 'Jl. Hayam Wuruk, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79561666666667',
			  'longitude' => '110.372648055556'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PORTABLE JL. LEMPUYANGAN',
			  'lokasi_halte' => 'Jl. Lempuyangan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79042777777778',
			  'longitude' => '110.374222222222'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE TAMAN SISWA',
			  'lokasi_halte' => 'Jl. Taman Siswa, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81271666388889',
			  'longitude' => '110.376652777778'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE PORTABLE JL. MENTERI SUPENO 2',
			  'lokasi_halte' => 'Jl. Menteri Supeno, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81628888611111',
			  'longitude' => '110.382463886111'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE UAD',
			  'lokasi_halte' => 'Jl. Pramuka, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.816402775',
			  'longitude' => '110.383055555556'
	  ]);
	  
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'PORTABLE JL. PANDEYAN 1',
			  'lokasi_halte' => 'Jl.Pandeyan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81565',
			  'longitude' => '110.38625'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'PORTABLE JL. GLAGAHSARI',
			  'lokasi_halte' => 'Jl. Glagahsari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80397222222222',
			  'longitude' => '110.388775'
	  ]);
	  
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SGM',
			  'lokasi_halte' => 'Jl. Kenari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80038333333333',
			  'longitude' => '110.394736111111'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE APMD 1',
			  'lokasi_halte' => 'Jl. Timoho, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79109444444444',
			  'longitude' => '110.393361111111'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE UIN SUNAN KALIJAGA 1',
			  'lokasi_halte' => 'Jl. Timoho, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78582833333333',
			  'longitude' => '110.394783333333'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE AA YKPN',
			  'lokasi_halte' => 'Jl. Langensari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78611361111111',
			  'longitude' => '110.383101666667'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE UIN SUNAN KALIJAGA 2',
			  'lokasi_halte' => 'Jl. Timoho, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.78611083333333',
			  'longitude' => '110.394930555556'
	  ]);
	  
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE AMPD 2',
			  'lokasi_halte' => 'Jl. Timoho, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.79109166666667',
			  'longitude' => '110.393265'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'HALTE SMKN 5',
			  'lokasi_halte' => 'Jl. Kenari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80030277777778',
			  'longitude' => '110.395108333333'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'PORTABLE MMUTY JL. GLAGAHSARI',
			  'lokasi_halte' => 'Jl. Glagahsari, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.80545997222222',
			  'longitude' => '110.388381638889'
	  ]);
	
	  DB::table('bus_stop')->insert([
			  'nama_halte'  => 'PORTABLE JL. PANDEYAN 2',
			  'lokasi_halte' => 'Jl. Pandeyan, Yogyakarta, Indonesia',
			  'last_bus' => '450',
			  'latitude' => '-7.81511944444444',
			  'longitude' => '110.386388888889'
	  ]);
  }
}
