<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BusOperation;
use App\ArrivalEstimation;

class BusController extends Controller
{
  public function addBus(Request $requests){
    $plat_nomor = $requests->input('plat_nomor');
    $rute = $requests->input('rute');
    //untuk store token bus
    $random_token = substr(md5(rand()), 0, 10);

    $bus = new BusOperation;
    $bus->plat_nomor = $plat_nomor;
    $bus->rute_id = $rute;
    $bus->token = $random_token;
    $bus->save();
  }

  public function displayForm(){
    return view('sign_up_bus');
  }

  public function listAllBusOperation(){
    $busOperationModel = new BusOperation();
    $listBusOperation = $busOperationModel->get()
                                      ->toArray();

    $this->listDetailAllBus = $listBusOperation;

    $this->statusDeviceBus();
  }

  public function displayListBusOperation(){

  }

  public $listDetailAllBus = array();
  //web service, executed every there is incoming request
  public function statusDeviceBus(){
    $busOperationModel = new BusOperation();

    for($i=0; $i<sizeof($this->listDetailAllBus); $i++){
      $lastUpdate = $this->listDetailAllBus[$i]['updated_at'];
      $lastUpdate = new \DateTime($lastUpdate);

      $nowTime = date("Y-m-d h:i:s");
      $nowTime = new \DateTime($nowTime);
      $interval = $lastUpdate->diff($nowTime);
      $lastVisible = $interval->d . " days " . $interval->h . " hours " . $interval->i . " minutes " .
          $interval->s . "seconds ago";
      $totalInMinutes = $interval->y*12*30*24*60 + $interval->m*30*24*60 + $interval->d*24*60 + $interval->h*60 +
          $interval->i;

      $this->getNearestArrivalByBus($this->listDetailAllBus[$i]['plat_nomor'], $i);

      $this->listDetailAllBus[$i]['device_status'] = array();

      if ($totalInMinutes>=30){
        $busOperationModel->where('plat_nomor', '=', $this->listDetailAllBus[$i]['plat_nomor'])
            ->update([
                'device_status' => "trouble"
            ]);

        $this->listDetailAllBus[$i]['device_status']['status'] = "trouble";
      } else {
        $busOperationModel->where('plat_nomor', '=', $this->listDetailAllBus[$i]['plat_nomor'])
            ->update([
                'device_status' => "running"
            ]);

        $this->listDetailAllBus[$i]['device_status']['status'] = "running";
      }
      $this->listDetailAllBus[$i]['last_visible']['exact'] = $lastVisible;
      $this->listDetailAllBus[$i]['last_visible']['total'] = $totalInMinutes;
    }

    $response = array();
    $response['code'] = 200;
    $response['data'] = $this->listDetailAllBus;
    echo json_encode($response);
  }

  public function getNearestArrivalByBus($plat_nomor, $position){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('plat_nomor', '=', $plat_nomor)
                                                ->orderBy('waktu_kedatangan', 'asc')
                                                ->with('thisHalte')
                                                ->with('toHalte')
                                                ->first();

    $this->listDetailAllBus[$position]['arrival'] = $arrivalEstimation;
  }
}
