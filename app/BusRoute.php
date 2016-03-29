<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusRoute extends Model
{
  protected $table = 'bus_route';
  public $timestamps = false;

  /**
   * satu halte_id di satu urutan rute, have one bus stop detail
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function detailHalte(){
    return $this->belongsTo('App\BusStop', 'halte_id', 'halte_id');
  }

  public function operatingBus(){
    return $this->hasOne('App\BusStopHistory', 'halte_id', 'halte_id');
  }
}
