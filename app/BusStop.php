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

  /**
   * get route_id that has certain bus stop in route list
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function includeRoute(){
    return $this->hasMany('App\BusRoute', 'halte_id', 'halte_id');
  }

  /**
   * get bus that have visited certain bus stop, if bus route still not completed yet
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function visitedBus(){
    return $this->hasMany('App\BusStopHistory', 'halte_id', 'halte_id');
  }

  /**
   * get arrival schedule to certain bus stop
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function haveArrivalSchedule(){
    return $this->belongsTo('App\ArrivalEstimation', 'halte_id', 'halte_id_tujuan');
  }
}
