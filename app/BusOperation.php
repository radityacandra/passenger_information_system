<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusOperation extends Model
{
  public $table = 'bus_operation';
  public $timestamps = true;

  public function havePositionLog(){
    return $this->hasMany('App\StoreLocationModel', 'plat_nomor', 'plat_nomor');
  }
}
