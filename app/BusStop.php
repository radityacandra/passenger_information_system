<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusStop extends Model
{
  protected  $table = 'bus_stop';
  public $timestamps = false;

  /**
   * get last bus visible to this bus stop
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function lastBus(){
    return $this->hasOne('App\BusOperation', 'last_bus', 'plat_nomor');
  }
}
