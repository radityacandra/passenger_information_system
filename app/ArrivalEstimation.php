<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrivalEstimation extends Model
{
  protected $table = 'arrival_estimation';
  public $timestamps = true;
  protected $fillable = ['updated_at', 'waktu_kedatangan', 'jarak'];
	protected $hidden = ['created_at'];

  /**
   * get next halte detail
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function nextHalte(){
    return $this->hasOne('App\BusStop', 'halte_id_tujuan', 'halte_id');
  }

  /**
   * get current halte detail
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function thisHalte(){
    return $this->hasOne('App\BusStop', 'halte_id', 'halte_id_asal');
  }

  /**
   * get next halte detail
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function toHalte(){
    return $this->hasOne('App\BusStop', 'halte_id', 'halte_id_tujuan');
  }

  /**
   * get list of route based on route id
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function routePlan(){
    return $this->hasMany('App\BusRoute', 'rute_id', 'rute_id');
  }
}
