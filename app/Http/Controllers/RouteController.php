<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BusRoute;
use App\Route;
use App\BusOperation;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
	public function displayAllRoute(){
		$response = array();
		try{
			$busRouteModel = new BusRoute();
			$busRoute = $busRouteModel->select('rute_id')
					->groupBy('rute_id')
					->get()
					->toArray();
			
			if(isset($busRoute[0])){
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
}
