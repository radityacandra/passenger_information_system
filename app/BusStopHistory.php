<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusStopHistory extends Model
{
  protected $table = 'bus_stop_history';
  public $timestamps = false;

  /**
   * get detail bus stop foreach record in bus_stop_history
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function detailHalte(){
    return $this->belongsTo('App\BusStop', 'halte_id', 'halte_id');
  }

  public function routeOrder(){
    return $this->belongsTo('App\BusRoute', 'halte_id', 'halte_id');
  }
}
