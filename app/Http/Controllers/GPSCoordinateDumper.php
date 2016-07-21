<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Httpful\Mime;

class GPSCoordinateDumper extends Controller{
  public $coordinate = array();

  public function setCoordinate(){
    $this->coordinate[0] = ['-7.78175', '110.450583333333'];
    $this->coordinate[1] = ['-7.782684', '110.448660'];
    $this->coordinate[2] = ['-7.783566', '110.446385'];
    $this->coordinate[3] = ['-7.783555', '110.443714'];
    $this->coordinate[4] = ['-7.783545', '110.440988'];
    $this->coordinate[5] = ['-7.783566', '110.438027'];
    $this->coordinate[6] = ['-7.78458333333333', '110.436361111111'];

    $this->coordinate[7] = ['-7.783421', '110.433160'];
    $this->coordinate[8] = ['-7.783575', '110.429995'];
    $this->coordinate[9] = ['-7.783490', '110.426755'];
    $this->coordinate[10] = ['-7.783394', '110.423687'];
    $this->coordinate[11] = ['-7.783341', '110.420962'];
    $this->coordinate[12] = ['-7.78341666666667', '110.419333333333'];

    $this->coordinate[13] = ['-7.783398', '110.417198'];
    $this->coordinate[14] = ['-7.783425', '110.414753'];
    $this->coordinate[15] = ['-7.783372', '110.411893'];
    $this->coordinate[16] = ['-7.784212', '110.410567'];
    $this->coordinate[17] = ['-7.78575', '110.410444444444'];
  }

  public $localUrl = 'http://127.0.0.1/pis/api/';
  public $remoteUrl = 'http://smartcity.wg.ugm.ac.id/webapp/passenger_information_system/public/api/';

  public function doGPSDump($index){
    $this->setCoordinate();

    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }
    echo $baseUrl;
    $postLocationUrl = $baseUrl.'bus/operation';
    $parameter = array(
      'plat'    => 'AB7529LB',
      'token'   => '3875115bac',
      'rute_id' => '1A',
      'lat'     => $this->coordinate[$index][0],
      'long'    => $this->coordinate[$index][1],
      'speed'   => '30'
    );

    $response = \Httpful\Request::post($postLocationUrl)
    ->sendsType(Mime::FORM)
    ->body(http_build_query($parameter))
    ->send();

    echo $response->raw_body;
    echo "send data ke-".$index;

    //return redirect('testing/dumpgps/'.$index+1);
    return redirect()->action('GPSCoordinateDumper@doGPSDump', [$index+1]);
  }
}
