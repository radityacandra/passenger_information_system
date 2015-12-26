<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\HttpCache\Store;

use App\StoreLocationModel;
use App\BusOperation;

class StoreLocationController extends Controller
{
    /**
     * controller buat handle request post ke URI /report_location
     * attribut post ada rute_id, lat, long, speed, semua dikirim plain form request
     * @param Request $requests
     */
    public function postLocation(Request $requests){
        $plat = $requests->input('plat');
        $input_token = $requests->input('token');

        $bus = new BusOperation;
        $reference_token = $bus->select('token')->where('plat_nomor','=', $plat)->get()->toArray();

        if($input_token==$reference_token[0]['token']){
            $location = new StoreLocationModel;
            $location->route_id = $requests->input('rute_id');
            $location->latitude = $requests->input('lat');
            $location->longitude = $requests->input('long');
            $location->avg_speed = $requests->input('speed');
            $location->plat_nomor = $plat;
            $location->save();

            if($location->save()){
                $response = "data berhasil disimpan";
                echo $response;
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
}
