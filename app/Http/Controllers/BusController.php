<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BusOperation;
use App\ArrivalEstimation;
use App\BusRoute;
use App\BusStopHistory;
use App\BusMaintenance;

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

  /**
   * get remaining bus stop information based on route_id of the bus and visited bus stop
   * @param $plat_nomor
   */
  public function remainingBusStop($plat_nomor){
    $busOperationModel = new BusOperation();
    $busRouteModel = new BusRoute();
    $busStopHistoryModel = new BusStopHistory();
    $response = array();

    try{
      if($plat_nomor=='all'){
        $listBusOperation = $busOperationModel->get()
                                              ->toArray();
        $counter = 0;
        $dataContainer = array();
        foreach($listBusOperation as $busOperation){
          $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $plat_nomor)
              ->get()
              ->toArray();

          $visitedBusStopArray = array();
          for($i=0; $i<sizeof($busStopHistory); $i++){
            $visitedBusStopArray[$i] = $busStopHistory[$i]['halte_id'];
          }

          $busRoute = $busRouteModel->where('rute_id', '=', $busOperation['rute_id'])
              ->whereNotIn('halte_id', $visitedBusStopArray)
              ->with('detailHalte')
              ->get()
              ->toArray();

          if($busRoute!=null){
            $dataContainer[$counter] = $busRoute;
          } else {
            $dataContainer[$counter]['msg'] = 'route is not registered in system';
          }

          $counter++;
        }

        $response['code'] = 200;
        $response['data'] = $dataContainer;
      } else {
        $busOperation = $busOperationModel->where('plat_nomor', '=', $plat_nomor)
                                          ->firstOrFail();

        $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $plat_nomor)
                                              ->get()
                                              ->toArray();

        $visitedBusStopArray = array();
        for($i=0; $i<sizeof($busStopHistory); $i++){
          $visitedBusStopArray[$i] = $busStopHistory[$i]['halte_id'];
        }

        $busRoute = $busRouteModel->where('rute_id', '=', $busOperation['rute_id'])
                                  ->whereNotIn('halte_id', $visitedBusStopArray)
                                  ->with('detailHalte')
                                  ->get()
                                  ->toArray();

        $response['code'] = 200;
        if($busRoute!=null){
          $response['data'] = $busRoute;
        } else {
          $response['data']['msg'] = 'route is not registered in system';
        }
      }
    } catch(\Exception $e) {
      $response['code'] = 200;
      $response['data']['msg'] = 'bus is not registered in system';
    }

    echo json_encode($response);
  }

  /**
   * add bus maitenance record
   * bus maintenance most come from bus operation, so we can delete bus operatonal record for record migration
   * @param $plat_nomor
   */
  public function addBusMaintenance($plat_nomor){
    $busOperationModel = new BusOperation();
    $busMaintenanceModel = new BusMaintenance();

    $response = array();

    try {
      $busOperation = $busOperationModel->where('plat_nomor', '=', $plat_nomor)
          ->firstOrFail();
      $busOperationModel->where('plat_nomor', '=', $plat_nomor)
          ->delete();

      $busMaintenanceModel->plat_nomor = $plat_nomor;
      $busMaintenanceModel->created_at = \Carbon\Carbon::now();
      $busMaintenanceModel->updated_at = \Carbon\Carbon::now();
      $busMaintenanceModel->token = $busOperation['plat_nomor'];
      $busMaintenanceModel->save();

      $response['code'] = 200;
      $response['data']['msg'] = 'transaction successfully executed';
    } catch (\Exception $e) {
      $response['code'] = 400;
      $response['data']['msg'] = 'bus is not registered in our system';
    }

    echo json_encode($response);
  }
}
