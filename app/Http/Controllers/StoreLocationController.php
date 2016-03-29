<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Httpful\Httpful;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\HttpCache\Store;

use App\StoreLocationModel;
use App\BusOperation;
use App\BusStop;
use App\ArrivalEstimation;
use App\BusRoute;
use App\BusStopHistory;

use App\Helpers\RandomString;

class StoreLocationController extends Controller
{
  public $plat_nomor, $rute_id, $avg_speed;
  public $busLat, $busLon;

  /**
   * controller buat handle request post ke URI /report_location
   * attribut post ada rute_id, lat, long, speed, semua dikirim plain form request
   * @param Request $requests
   */
  public function postLocation(Request $requests){
    $plat = $requests->input('plat');
    $this->plat_nomor = $plat;

    $input_token = $requests->input('token');

    $bus = new BusOperation;
    $reference_token = $bus->select('token')->where('plat_nomor','=', $plat)->get()->toArray();

    if($input_token==$reference_token[0]['token']){
      $location = new StoreLocationModel;
      $location->route_id = $requests->input('rute_id');
      $this->rute_id = $requests->input('rute_id');
      $location->latitude = $requests->input('lat');
      $this->busLat = $requests->input('lat');
      $location->longitude = $requests->input('long');
      $this->busLon = $requests->input('long');
      $location->avg_speed = $requests->input('speed');
      $this->avg_speed = $requests->input('speed');
      $location->plat_nomor = $plat;
      $location->save();

      if($location->save()){
        $this->selectBusHistory();
        $this->getAllBusStop();
        $this->updateBusOperation();
        $this->checkBusLocationStatus();
        $this->checkBusStopHistory();
      }
    }
    else{
      $this->response['data']['msg'] = 'transaction failed, make sure all fields are filled';
      $this->response['code'] = 400;
      return response()->json($this->response);
    }
  }

  /**
   * buat get arrival estimation berdasarkan id bus
   */
  public function reportLocation(){
    $location = new StoreLocationModel;
    $data = $location->take(1)->get();
    echo json_encode($data);
  }

  /**
   * get token bus, need plat nomor and device_id for authorization
   */
  public function getTokenBus(Request $request){
    $plat_nomor = $request->input('plat');
    $token_secret = $request->input('token');
    $bus = new BusOperation;
    $busDetail = $bus->where('plat_nomor', '=', $plat_nomor)
                      ->where('device_id', '=', $token_secret)
                      ->first();

    $response = array();

    if(sizeof($busDetail>0)){
      $token = RandomString::randomString();
      $bus->where('plat_nomor', '=', $plat_nomor)
          ->update(['token' => $token]);
      $response['data']['token'] = $token;
      $response['code'] = 200;
    } else{
      $response['data']['msg'] = 'device_id / plat nomor doesnt match';
      $response['code'] = 400;
    }

    echo json_encode($response);
  }

  public function accessDenied(){
    return view('Forbidden');
  }

  /**
   * update bus operation current location and speed based on bus plat nomor
   */
  public function updateBusOperation(){
    $busOperationModel = new BusOperation();
    $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)->first();
    $busOperationModel->update([
      'rute_id'       => $this->rute_id,
      'last_latitude' => $this->busLat,
      'last_longitude'=> $this->busLon,
      'avg_speed'     => $this->avg_speed,
      'updated_at'    => Carbon::now()
    ]);
  }

  public $listBusHistory;
  /**
   * get all visited bus stop based on plat nomor
   */
  public function selectBusHistory(){
    $busHistoryModel = new BusStopHistory();
    $busHistory = $busHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
                                  ->get()
                                  ->toArray();
    $counter = 0;
    foreach($busHistory as $itemBusHistory){
      $this->listBusHistory[$counter] = $itemBusHistory['halte_id'];
      $counter++;
    }
  }

  public $listBusStopDuration = array();
  /**
   * get all bus stop duration arrival to current bus route
   * EXCEPT previously visited bus stop
   * todo: filter nearest bus stop
   */
  public function getAllBusStop(){
    $counter = 0;
    $busRoute = new BusRoute();
    $response = $busRoute->where('rute_id', '=', '1A')
        ->where('halte_id', 'not like', '('.implode(',', $this->listBusHistory).')')
        ->with('detailHalte')
        ->get()
        ->toArray();
    foreach($response as $busRoute){
      $param = array(
          'units'       => 'imperial',
          'origins'     => $this->busLat . ', ' . $this->busLon,
          'destinations'=> $busRoute['detail_halte']['latitude'] . ', ' . $busRoute['detail_halte']['longitude'],
          'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
      );

      $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?' . http_build_query($param);
      $response = \Httpful\Request::get($url)->send();
      $dataResponse = json_decode($response->raw_body, true);
      $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
      $this->listBusStopDuration[$counter] = $dataResponse;
      $counter++;
    }

    $this->makeOrUpdateAllArrivalEstimation();
  }

  public $nearestBusStop = array();
  /**
   * get nearest bus stop between all bus stop duration grabbed from google distance matrix
   * todo: get last bus stop
   */
  public function filterNearestBusStop(){
    $counter = 0;
    foreach ($this->listBusStopDuration as $durationResponse){

      if($counter == 0){
        $this->nearestBusStop = $durationResponse;
      } else{
        if((integer)$durationResponse['rows'][0]['elements'][0]['duration']['value'] < (integer)$this->nearestBusStop['rows'][0]['elements'][0]['duration']['value']){
          $this->nearestBusStop = $durationResponse;
        }
      }

      $counter++;
    }

    $this->getLastBusStop();
  }

  public $busStop = array();
  /*
   * get last visited bus stop bus operation
   * todo: make/update arrival estimation
   */
  public function getLastBusStop(){
    $busStopModel = new BusStop();
    $busStop = $busStopModel->where('last_bus', '=', $this->plat_nomor)->first();
    $this->busStop = $busStop;
  }

  public $response = array();
  /**
   * insert or update arrival estimation
   * if it already exist, just update
   * if it not exist yet, insert new arrival estimation
   */
  public function makeOrUpdateAllArrivalEstimation(){
    foreach($this->listBusStopDuration as $busStopDuration){
      $arrivalEstimationModel = new ArrivalEstimation();
      $arrivalEstimation = $arrivalEstimationModel->where('plat_nomor', '=', $this->plat_nomor)
          ->where('halte_id_tujuan', '=', $busStopDuration['halte_id'])
          ->first();

      //echo $busStopDuration['rows'][0]['elements'][0]['duration']['value'].'<br />';

      if(sizeof($arrivalEstimation) == 0){
        //make new record in arrival_estimation
        $arrivalEstimationModel1 = new ArrivalEstimation();
        $arrivalEstimationModel1->created_at = Carbon::now();
        $arrivalEstimationModel1->updated_at = Carbon::now();
        $arrivalEstimationModel1->halte_id_tujuan = $busStopDuration['halte_id'];
        //if bus is just depart from garage, halte id is empty, then we must prepare
        if(isset($this->busStop['halte_id'])){
          $arrivalEstimationModel1->halte_id_asal = $this->busStop['halte_id'];
        }
        $arrivalEstimationModel1->waktu_kedatangan = $busStopDuration['rows'][0]['elements'][0]['duration']['value'];
        $arrivalEstimationModel1->jarak = $busStopDuration['rows'][0]['elements'][0]['distance']['value'];
        $arrivalEstimationModel1->rute_id = $this->rute_id;
        $arrivalEstimationModel1->plat_nomor = $this->plat_nomor;
        $arrivalEstimationModel1->save();
        $this->response['code'] = 200;
        $this->response['data']['msg'] = 'make new arrival estimation';
      } else{
        //update value in arrival_estimation
        $arrivalEstimationModel2 = new ArrivalEstimation();
        $arrivalEstimationModel2->where('plat_nomor', '=', $this->plat_nomor)
                                ->where('halte_id_tujuan', '=', $busStopDuration['halte_id'])
                                ->update([
                                    'updated_at'      => Carbon::now(),
                                    'waktu_kedatangan'=> $busStopDuration['rows'][0]['elements'][0]['duration']['value'],
                                    'jarak'           => $busStopDuration['rows'][0]['elements'][0]['distance']['value']
                                ]);
        $this->response['code'] = 200;
        $this->response['data']['msg'] = 'update arrival estimation';
      }
    }
    echo json_encode($this->response);
  }

  /**
   * check if bus has arrived to nearest bus stop on its route
   * todo: detect if bus has arrived to certain bus stop
   */
  public function checkBusLocationStatus(){
    $this->filterNearestBusStop();
    if($this->nearestBusStop['rows'][0]['elements'][0]['distance']['value']<=15){
      $arrivalEstimationModel = new ArrivalEstimation();
      $arrivalEstimationModel->where('halte_id', '=', $this->nearestBusStop['halte_id'])
                              ->delete();

      $busStop = new BusStop();
      $busStop->where('halte_id', '=', $this->nearestBusStop['halte_id'])
              ->update(['last_bus' => $this->plat_nomor]);

      $busStopHistoryModel = new BusStopHistory();
      $busStopHistoryModel->plat_nomor = $this->plat_nomor;
      $busStopHistoryModel->halte_id = $this->nearestBusStop['halte_id'];
      $busStopHistoryModel->rute_id = $this->rute_id;
      $busStopHistoryModel->save();
    }
  }

  /**
   * check bus stop history,
   * if last visited bus is the last bus stop on its route, then delete record that related to that bus
   */
  public function checkBusStopHistory(){
    $this->plat_nomor = 'AB1234BA';
    $busStopHistoryModel = new BusStopHistory();
    $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
                                          ->orderBy('arrival_history', 'desc')
                                          ->with('routeOrder')
                                          ->take(1)
                                          ->get()
                                          ->toArray();

    if(sizeof($busStopHistory > 0)){
      $busRouteModel = new BusRoute();
      $lastRouteOrder = $busRouteModel->where('rute_id', '=', $busStopHistory[0]['rute_id'])
          ->orderBy('urutan', 'desc')
          ->take(1)
          ->get()
          ->toArray();

      //if bus has reach the last bus stop on its route, then delete related record
      if($busStopHistory[0]['route_order']['urutan'] == $lastRouteOrder[0]['urutan']){
        $busStopHistoryModel = new BusStopHistory();
        $busStopHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
                            ->delete();
      }
    }
  }
}
