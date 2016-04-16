<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpeedViolation extends Model
{
  protected $table = 'speed_violation';
  public $timestamps = true;

  /**
   * get detail information about bus violate rule
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function detailBus(){
    return $this->belongsTo('App\BusOperation', 'plat_nomor', 'plat_nomor');
  }
}
