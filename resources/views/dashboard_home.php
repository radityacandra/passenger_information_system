<!doctype html>
<html ng-app>
<head>
  <title>Dashboard Transjogja</title>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvyyijm6cgfQmrd5Sn-T8OltJdK4WkRQ8&callback=initMap"></script>
  <script type="text/javascript">
    //for google maps
    function initMap(){
      var map;
      var directionDisplay = new google.maps.DirectionsRenderer();
      var directionService = new google.maps.DirectionsService();

      var mapOptions = {
        center: {lat:-7.767931, lng:110.374198}, //koordinat halte bus sebagai center of map
        zoom: 17
      };
      map = new google.maps.Map(document.getElementById('map'), mapOptions);
      directionDisplay.setMap(map);

      //titik awal dan titik akhir
      var origin = new google.maps.LatLng(-7.76780555555556, 110.37425); //panggil ajax posisi bus saat ini
      var destination = new google.maps.LatLng(<?php echo $viewData['detail_bus_stop']['latitude']; ?>, <?php echo
      $viewData['detail_bus_stop']['longitude']; ?>); //posisi halte tujuan

      //buat deskripsi latitude longitude yang harus dilewati rute. Buat versi free maksimal 8 waypoints
      //optional, karena letak halte kebanyakan di jalan besar, jadi routing sudah sesuai
      /*var through1 = new google.maps.LatLng();
       var through2 = new google.maps.LatLng();
       var through3 = new google.maps.LatLng();*/

      //waypoints dijadikan satu array
      /*var wps = [{location: through1}, {location: through2}, {location:through3}];*/

      //parameter request yang dikirimkan ke google maps API
      var request = {
        origin: origin,
        destination: destination,
        //waypoint di print di request kalau dibutuhkan saja
        //waypoints: wps,
        travelMode: google.maps.TravelMode.DRIVING,
        drivingOptions: {
          departureTime: new Date(/* now, or future date */),
          trafficModel: google.maps.TrafficModel.BEST_GUESS
        }
      };

      //kirim request sekaligus handler result request
      directionService.route(request, function(result, status){
        if(status==google.maps.DirectionsStatus.OK){
          directionDisplay.setDirections(result);
          console.log(result);

          var point = result.routes[ 0 ].legs[ 0];
          console.log(point);

        }
        else {
          window.alert('Directions request failed due to ' + status);
        }
      });
    }
  </script>

  <script>
    //for timer
    <?php
    if (isset($viewData['nearest_bus']['waktu_kedatangan'])) {
      echo "deadline=".$viewData['nearest_bus']['waktu_kedatangan'];
    } else {
      echo "deadline=0";
    }
    ?>

    function getTimeRemaining(endtime){

      var seconds = Math.floor((endtime) % 60);
      var minutes = Math.floor((endtime/60) % 60);
      var hours = Math.floor((endtime/60/60) % 60);

      deadline--;

      return {
        'total'     : endtime,
        'hours'     : hours,
        'minutes'   : minutes,
        'seconds'   : seconds
      };
    }

    function initializeClock(id){
      var divClock = document.getElementById(id);
      var timeInterval = setInterval(function(){
        var t = getTimeRemaining(deadline);
        divClock.innerHTML = t.hours + ' jam ' + t.minutes + ' menit ' + t.seconds +' detik ';

        if (t.total<0){
          clearInterval(timeInterval);
        }
      }, 1000);
    }
  </script>

  <script>
    //for weather data
    function getWeatherData(lat, long){
      var json = $.ajax({
        url: "http://api.openweathermap.org/data/2.5/weather",
        dataType: "json",
        type: "GET",
        async: false,
        data: "lat="+lat+"&lon="+long+"&units=metric&appid=bb9fce025fb0c0c8e348f723bddfedd1"
      }).responseText;
      var responseData = JSON.parse(json);
      return responseData;
    }

    function initializeWeather(id, id2, lat, lon){
      var responseData = getWeatherData(lat, lon);
      console.log("respon weather: "+ responseData.main.temp);
      var setDiv = document.getElementById(id);
      setDiv.innerHTML = responseData.main.temp + "&deg; C";

      console.log("respon weather: "+ responseData.weather[0].description);
      var setDiv2 = document.getElementById(id2);
      setDiv2.innerHTML = responseData.weather[0].description;
    }
  </script>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style type="text/css">
    html, body { height: 100%; margin: 0; padding: 0; }
    #map { height: 100%; }

    .navbar, .navbar.navbar-default {
      background-color: #009688;
      color: rgba(255,255,255, 0.84);
    }
  </style>
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
  <?php echo Html::style('css/dashboard_home.css'); ?>
</head>

<body>
<!--navbar-->
<div class="bs-component">
  <div class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="javascript:void(0)"><img src="img/logo.gif" width="50" /></a>
      </div>
      <div class="navbar-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
          <li><a href="javascript:void(0)" style="font-size: x-large; ">Sistem Informasi Penumpang Bus > Detail Halte</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="img/ic_settings_white_24dp_1x.png"/>
              <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)">Action</a></li>
              <li><a href="javascript:void(0)">Another action</a></li>
              <li><a href="javascript:void(0)">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="javascript:void(0)">Separated link</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!--container 1st row-->
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">Bus Terdekat Menuju Halte</div>
      <div class="panel-body">
        <div id="map" style="height: 150px"></div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Kedatangan Terdekat</div>
      <div class="panel-body">
        <?php if (isset($viewData['nearest_bus']['rute_id'])) { ?>
          <h3>Rute <?php echo $viewData['nearest_bus']['rute_id']; ?></h3>
        <?php } ?>
        <h5>in</h5>
        <h4><div id="clock"><script type=text/javascript>initializeClock('clock')</script></div></h4>
        <h5>current speed: 40km/h</h5>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Halte Pemberhentian Selanjutnya</div>
      <div class="panel-body">
        <?php
          $nextRoute = $viewData['next_route'];
          if (isset($nextRoute[0]['detail_halte']['nama_halte'])) {
            echo '<h4>' . $nextRoute[0]['detail_halte']['nama_halte'] . '</h4>';
          }
          echo '<table class="table table-striped table-hover">';
          if(isset($nextRoute[1]['detail_halte']['nama_halte']))
          echo '<tr class="success"><td>'.$nextRoute[1]['detail_halte']['nama_halte'].'</td></tr>';
          if(isset($nextRoute[2]['detail_halte']['nama_halte']))
          echo '<tr class="success"><td>'.$nextRoute[2]['detail_halte']['nama_halte'].'</td></tr>';
          echo '</table>';
        ?>
      </div>
    </div>
  </div>
</div>

<!--container 2nd row-->
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Jadwal Kedatangan Bus</div>
      <div class="panel-body">
        <table class="table table-striped table-hover">
          <thead>
          <tr>
            <th>#</th>
            <th>Nomor Rute</th>
            <th>Waktu Kedatangan</th>
          </tr>
          </thead>
          <tbody>
          <?php
            $counter = 1;
            foreach ($viewData['next_bus_stop'] as $nextBusStop){
              echo '<tr class="info">';
              echo '<td>'.$counter.'</td>';
              echo '<td>'.$nextBusStop['rute_id'].'</td>';
              echo '<td>'.$nextBusStop['waktu_kedatangan'].'</td>';
              echo '</tr>';
              $counter++;
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Riwayat Keberangkatan Bus</div>
      <div class="panel-body">
        <table class="table table-striped table-hover">
          <thead>
          <tr>
            <th>#</th>
            <th>Nomor Rute</th>
            <th>Waktu Keberangkatan</th>
          </tr>
          </thead>
          <tbody>
          <?php
            $counter = 1;
            if(isset($viewData['departure_history'][0])){
              foreach($viewData['departure_history'] as $departureHistory){
                echo '<tr>';
                echo '<td>'.$counter.'</td>';
                echo '<td>'.$departureHistory['rute_id'].'</td>';
                echo '<td>12.30 WIB</td>';
                echo '</tr>';
              }
            } else {
              echo '<tr>';
              echo '<td colspan="3">(Belum ada bus yang berangkat dari halte ini)</td>';
              echo '</tr>';
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Informasi Halte</div>
      <div class="panel-body">
        <?php
          echo '<h4>'.$viewData['detail_bus_stop']['nama_halte'].'</h4>';
          echo '<h5>'.$viewData['detail_bus_stop']['lokasi_halte'].'</h5>';
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Ramalan Cuaca</div>
      <div class="panel-body">
        <div class="col-md-4"><img src="img/clear_weather.png" style="width: 100%; " /></div>
        <div class="col-md-8"><h2><div id="temperature"></div></h2></div>
        <div class="col-md-12"><h4><div id="forecast"></div></h4></div>
      </div>
    </div>
  </div>

  <div class="col-md-12" style="word-wrap: break-word;">
    <div class="panel panel-default" style="word-wrap: break-word;">
      <div class="panel-heading">Info Lalulintas Terkini</div>
      <div class="panel-body">
        <div class="a">
          <?php
            for($i = 0; $i<sizeof($viewData['recent_news']); $i++){
              echo '<div class="date"><b>'.$viewData['recent_news'][$i]['judul'].'</b></div>';
              echo '<div class="content">'.$viewData['recent_news'][$i]['content'].'</div>';
              if($i < sizeof($viewData['recent_news']) - 1){
                echo '<hr>';
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php /*echo csrf_token(); */?>

<script type="text/javascript" src="<?php echo URL::asset('js/angular.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
<script type=text/javascript>
  initializeWeather("temperature", "forecast", <?php echo $viewData['detail_bus_stop']['latitude'] ?>, <?php echo $viewData['detail_bus_stop']['longitude'] ?>)
</script>
</body>
</html>
