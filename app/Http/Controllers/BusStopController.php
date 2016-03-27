<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ArrivalEstimation;

class BusStopController extends Controller
{

  public $listArrivalEstimation;
  /**
   * get arrival estimation for certain halte_id
   */
  public function getArrivalEstimation($halte_id){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', '=', $halte_id)->get()->toArray();

    $this->listArrivalEstimation = $arrivalEstimation;

    echo json_encode($arrivalEstimation);
  }

  public $nearestArrivalEtimation = array();
  public function getNearestArrivalEstimation(){
    $counter = 0;
    foreach($this->listArrivalEstimation as $arrivalEstimation){
      if($counter == 0){
        $this->nearestArrivalEtimation = $arrivalEstimation;
      } else{
        if((integer)$arrivalEstimation['rows'][0]['elements'][0]['duration']['value'] < (integer)$this->nearestBusStop['rows'][0]['elements'][0]['duration']['value']){
          $this->nearestArrivalEtimation = $arrivalEstimation;
        }
      }
    }
  }
}
