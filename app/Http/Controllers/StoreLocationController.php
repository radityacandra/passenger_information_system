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
        $response = "data berhasil disimpan";
        echo $response;
        $this->getAllBusStop();
        $this->updateBusOperation();
      }
    }
    else{
      echo 'autentikasi salah, make sure plat nomor benar';
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
   * get token bus, buat tambahan security
   */
  public function getTokenBus(Request $request){
    $plat_nomor = $request->input('plat');
    $bus = new BusOperation;
    $reference_token = $bus->select('token')->where('plat_nomor', '=', $plat_nomor)->get()->toArray();
    echo json_encode($reference_token[0]['token']);
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

  public $listBusStopDuration = array();
  /**
   * get all bus stop duration arrival to current bus route
   * todo: filter nearest bus stop
   */
  public function getAllBusStop(){
    $counter = 0;
    $busRoute = new BusRoute();
    $response = $busRoute->where('rute_id', '=', '1A')
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
    //$this->filterNearestBusStop();
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
    $this->makeOrUpdateArrivalEstimation();
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

  /**
   * insert or update arrival estimation
   * if it already exist, just update
   * if it not exist yet, insert new arrival estimation
   */
  public function makeOrUpdateArrivalEstimation(){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('plat_nomor', '=', $this->plat_nomor)
                                                ->where('halte_id_tujuan', '=', $this->nearestBusStop['halte_id'])
                                                ->first();

    if(sizeof($arrivalEstimation) == 0){
      //make new record in arrival_estimation
      $arrivalEstimationModel = new ArrivalEstimation();
      $arrivalEstimationModel->created_at = Carbon::now();
      $arrivalEstimationModel->updated_at = Carbon::now();
      $arrivalEstimationModel->halte_id_tujuan = $this->nearestBusStop['halte_id'];
      //if bus is just depart from garage, halte id is empty, then we must prepare
      if(isset($this->busStop['halte_id'])){
        $arrivalEstimationModel->halte_id_asal = $this->busStop['halte_id'];
      }
      $arrivalEstimationModel->waktu_kedatangan = $this->nearestBusStop['rows'][0]['elements'][0]['duration']['value'];
      $arrivalEstimationModel->jarak = $this->nearestBusStop['rows'][0]['elements'][0]['distance']['value'];
      $arrivalEstimationModel->rute_id = $this->rute_id;
      $arrivalEstimationModel->plat_nomor = $this->plat_nomor;
      $arrivalEstimationModel->save();
      echo 'make new arrival estimation';
    } else{
      //update value in arrival_estimation
      $arrivalEstimationModel->update([
        'updated_at'      => Carbon::now(),
        'waktu_kedatangan'=> $this->nearestBusStop['rows'][0]['elements'][0]['duration']['value'],
        'jarak'           => $this->nearestBusStop['rows'][0]['elements'][0]['distance']['value']
      ]);

      echo 'update arrival estimation';
    }
  }

  public function makeOrUpdateAllArrivalEstimation(){
    foreach($this->listBusStopDuration as $busStopDuration){
      $arrivalEstimationModel = new ArrivalEstimation();
      $arrivalEstimation = $arrivalEstimationModel->where('plat_nomor', '=', $this->plat_nomor)
          ->where('halte_id_tujuan', '=', $busStopDuration['halte_id'])
          ->first();

      echo $busStopDuration['rows'][0]['elements'][0]['duration']['value'].'<br />';

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
        echo 'make new arrival estimation';
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

        echo 'update arrival estimation';
      }
    }
  }

  //todo: detect if bus has arrived to certain bus stop
  public function checkBusLocationStatus(){
    $busRoute = new BusRoute();
    $response = $busRoute->where('rute_id', '=', '1A')
                          ->with('detailHalte')
                          ->get()
                          ->toArray();

    echo json_encode($response);
  }
}
