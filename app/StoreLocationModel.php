<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreLocationModel extends Model
{
    /**
     * Runtuhkan presepsimu, di sini model tidak berperan apa-apa, hanya mendefinisikan tabel yang bersangkutan
     * brace yourself man
     * SEMUA LOGIC DITULIS DI CONTROLLER
     */

    /**
     * nama database: dump_gps
     * buat terima post method dari gps tracker di bus
     * @var string
     */
    protected $table = 'dump_gps';
    protected $primaryKey = 'dump_id';
}
