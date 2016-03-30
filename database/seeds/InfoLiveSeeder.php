<?php

use Illuminate\Database\Seeder;

class InfoLiveSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('info_live')->delete();

    DB::table('info_live')->insert([
      'created_at'  => \Carbon\Carbon::now(),
      'updated_at'  => \Carbon\Carbon::now(),
      'judul'       => 'Flyover Janti Padat Merayap',
      'content'     => 'Hari libur nasional peringatan wafatnya Isa Almasih, Jumat, 25 Maret 2015, sejumlah ruas
      jalan yang dipantau Traffic Management Center Jakarta (TMC Polda Metro Jaya) dilaporkan dipadati kendaraan.',
      'penulis'     => 'Raditya Chandra Buana'
    ]);

    DB::table('info_live')->insert([
        'created_at'  => \Carbon\Carbon::now(),
        'updated_at'  => \Carbon\Carbon::now(),
        'judul'       => 'Lalu Lintas Tol Cikampek Km 5 Macet, Contra Flow Siap Dilakukan',
        'content'     => 'Arus lalu lintas di Tol Jakarta-Cikampek pada libur panjang akhir pekan ini terpantau macet
         di beberapa titik. Kondisi tersebut berlangsung sejak Kamis malam, 24 Maret 2016. "Sampai pagi ini masih
         macet. Memang pergerakan mencair dibanding kemarin. Masih banyak kendaraan yang menuju ke luar kota," kata
         petugas Jasa Marga, Mutia saat dihubungi Liputan6.com dari Jakarta, Jumat (25/3/2016). Mutia mengatakan,
         kemacetan berlangsung mulai dari Jatiwaringin tepatnya di Km 5. Antrean kendaraan mengular hingga mencapai
         Cikarang Timur Km 41. ',
        'penulis'     => 'Raditya Chandra Buana'
    ]);

    DB::table('info_live')->insert([
        'created_at'  => \Carbon\Carbon::now(),
        'updated_at'  => \Carbon\Carbon::now(),
        'judul'       => 'Ini Rute Pengalihan Lalu Lintas Tugu Jogja Saat Gerhana',
        'content'     => 'Masyarakat Yogyakarta yang biasanya melintas di simpang empat Tugu, sebaiknya mengambil
        jalur lain pada Rabu 9 Maret 2016. Sebab saat proses gerhana matahari terjadi, arus lalu lintas di Tugu Jogja
         akan ditutup. Kapolresta Yogyakarta Prihartono Eling Lelakon mengatakan, di Tugu Jogja akan ada acara nonton
          bareng gerhana matahari yang diselenggarakan Pemerintah Kota Yogyakarta dan BMKG. Polisi telah menggelar
          rapat dengan Pemkot Yogyakarta dan hasilnya akan ada ruas jalan yang ditutup dan dialihkan.',
        'penulis'     => 'Raditya Chandra Buana'
    ]);
  }
}
