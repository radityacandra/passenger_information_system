<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BusRoute;
use App\Route;
use App\BusOperation;
use App\ArrivalEstimation;

use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
	/**
	 * Display all operating route summary
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function displayAllRoute(){
		$response = array();
		try{
			$busRouteModel = new BusRoute();
			$routeModel = new Route();
			$busOperationModel = new BusOperation();
			
			$busRoute = $busRouteModel->select('rute_id')
					->groupBy('rute_id')
					->get()
					->toArray();
			
			if(isset($busRoute[0])){
				$counter = 0;
				foreach ($busRoute as $itemRoute){
					$rute_id = $itemRoute['rute_id'];
					
					$infoRoute = $routeModel->where('rute_id', '=', $rute_id)
							->get()
							->toArray();
					
					$totalBusStop = $busRouteModel->select(DB::raw('count(*) as total_halte'))
							->where('rute_id', '=', $rute_id)
							->get()
							->toArray();
					
					$totalBusOperation = $busOperationModel->select(DB::raw('count(*) as total_bus'))
							->where('rute_id', '=', $rute_id)
							->get()
							->toArray();
					
					$busRoute[$counter]['deskripsi'] = $infoRoute[0]['deskripsi'];
					$busRoute[$counter]['total_halte'] = $totalBusStop[0]['total_halte'];
					$busRoute[$counter]['total_bus'] = $totalBusOperation[0]['total_bus'];
					$counter++;
				}
				
				$response['code'] = 200;
				$response['data'] = $busRoute;
			} else{
				$response['code'] = 400;
				$response['data']['msg'] = "there is no route data, please contact administrator";
			}
		} catch (\Exception $e){
			$response['code'] = 500;
			$response['data']['msg'] = "internal server error, please contact administrator";
		}
		
		header("Access-Control-Allow-Origin: *");
		return response()->json($response);
	}
	
	/**
	 * Display route detail information
	 *
	 * @param $rute_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function busRouteDetail($rute_id){
		$response = array();
		
		try{
			$routeModel = new Route();
			$busRouteModel = new BusRoute();
			$busOperationModel = new BusOperation();
			
			$infoRoute = $routeModel->where('rute_id', '=', $rute_id)
					->get()
					->toArray();
			
			$totalBusStop = $busRouteModel->select(DB::raw('count(*) as total_halte'))
					->where('rute_id', '=', $rute_id)
					->get()
					->toArray();
			
			$totalBusOperation = $busOperationModel->select(DB::raw('count(*) as total_bus'))
					->where('rute_id', '=', $rute_id)
					->get()
					->toArray();
			
			if (isset($infoRoute[0]) && isset($totalBusStop[0]) && $totalBusOperation[0]){
				$container = array();
				$container['rute_id'] = $infoRoute[0]['rute_id'];
				$container['deskripsi'] = $infoRoute[0]['deskripsi'];
				$container['total_halte'] = $totalBusStop[0]['total_halte'];
				$container['total_bus'] = $totalBusOperation[0]['total_bus'];
				$response['code'] = 200;
				$response['data'] = $container;
			} else {
				$response['code'] = 400;
				$response['data']['msg'] = 'no route information can be found, make sure you attach a correct route identifier';
			}
		} catch (\Exception $e){
			$response['code'] = 500;
			$response['data']['msg'] = "internal server error, please contact administrator";
		}
		
		header("Access-Control-Allow-Origin: *");
		return response()->json($response);
	}
	
	/**
	 * Display bus operating in certain route
	 *
	 * @param $rute_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function busOperationInRoute($rute_id){
		$response = array();
		try{
			$arrivalEstimationModel = new ArrivalEstimation();
			
			$arrivalEstimation = $arrivalEstimationModel->where('rute_id', '=', $rute_id)
					->with(array('toHalte' => function($query){
						$query->addSelect('nama_halte', 'halte_id');
					}))
					->get()
					->toArray();
			
			if(isset($arrivalEstimation[0])){
				$response['code'] = 200;
				$response['data'] = $arrivalEstimation;
			} else {
				$response['code'] = 400;
				$response['data']['msg'] = "cannot find operating bus in this route, please try again later";
			}
		} catch (\Exception $e){
			$response['code'] = 500;
			$response['data']['msg'] = "internal server error, please contact administrator";
		}
		
		header("Access-Control-Allow-Origin: *");
		return response()->json($response);
	}
	
	/**
	 * Display bus stop operating in certain route
	 *
	 * @param $rute_id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function busStopOperationInRoute($rute_id){
		$response = array();
		try{
			$busRouteModel = new BusRoute();
			$busStop = $busRouteModel->select('rute_id', 'halte_id', DB::raw('halte_id as slug'))
					->where('rute_id', '=', $rute_id)
					->with(array('detailHalte'=>function($query){
						$query->addSelect('nama_halte', 'lokasi_halte', 'halte_id');
					}))
					->get()
					->toArray();
			
			if(isset($busStop[0])){
				for($i = 0; $i<sizeof($busStop); $i++){
					$busStop[$i]['rute_pass'] = $busRouteModel->select('rute_id')
							->where('halte_id', '=', $busStop[$i]['halte_id'])
							->groupBy('rute_id')
							->get()
							->toArray();
					unset($busStop[$i]['halte_id']);
				}
				
				$response['code'] = 200;
				$response['data'] = $busStop;
			} else{
				$response['code'] = 400;
				$response['data']['msg'] = 'cannot find operating bus stop in this route, please try again later';
			}
		} catch (\Exception $e){
			$response['code'] = 500;
			$response['data']['msg'] = "internal server error, please contact administrator";
		}
		
		header("Access-Control-Allow-Origin: *");
		return response()->json($response);
	}
}
