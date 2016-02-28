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
            var destination = new google.maps.LatLng(-7.77427777777778, 110.375138888889); //posisi halte tujuan

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
        deadline = '2016-02-22T01:00:00+07:00';

        function getTimeRemaining(endtime){
            var t = Date.parse(endtime) - Date.parse(new Date());
            var seconds = Math.floor((t/1000) % 60);
            var minutes = Math.floor((t/1000/60) % 60);
            var hours = Math.floor((t/1000/60/60) % 60);

            return {
                'total'     : t,
                'hours'     : hours,
                'minutes'   : minutes,
                'seconds'   : seconds
            };
        }

        function initializeClock(id, endtime){
            var divClock = document.getElementById(id);
            var timeInterval = setInterval(function(){
                var t = getTimeRemaining(endtime);
                divClock.innerHTML = t.minutes + ' m ' + t.seconds +' s ';

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
                data: "lat="+lat+"&lon="+long+"&units=metric&appid=44db6a862fba0b067b1930da0d769e98"
            }).responseText;
            var responseData = JSON.parse(json);
            return responseData;
        }

        function initializeWeather(id, lat, lon){
            var responseData = getWeatherData(lat, lon);
            console.log("respon weather: "+ responseData.main.temp);
            var setDiv = document.getElementById(id);
            setDiv.innerHTML = responseData.main.temp + "&deg; C";
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
                    <li><a href="javascript:void(0)" style="font-size: x-large; ">Home > Dashboard</a></li>
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
            <div class="panel-heading">Nearest Bus</div>
            <div class="panel-body">
                <div id="map" style="height: 300px"></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Arrival</div>
            <div class="panel-body">
                <h5>Rute A</h5>
                <p>in</p>
                <h4><div id="clock"><script type=text/javascript>initializeClock('clock',deadline)</script></div></h4>
                <p>current speed: 40km/h</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Next Stop</div>
            <div class="panel-body">
                <h4>Halte Cik Di Tiro</h4>
                <table class="table table-striped table-hover">
                    <tr class="success"><td>Jalan Diponegoro</td></tr>
                    <tr class="success"><td>Malioboro Stasiun Tugu</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!--container 2nd row-->
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Arrival Schedule</div>
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
                        <tr class="info">
                            <td>1</td>
                            <td>1 A</td>
                            <td>12.30 WIB</td>
                        </tr>
                        <tr class="info">
                            <td>2</td>
                            <td>1 B</td>
                            <td>12.30 WIB</td>
                        </tr>
                        <tr class="info">
                            <td>3</td>
                            <td>1 C</td>
                            <td>12.30 WIB</td>
                        </tr>
                        <tr class="info">
                            <td>1</td>
                            <td>1 A</td>
                            <td>12.30 WIB</td>
                        </tr>
                        <tr class="info">
                            <td>2</td>
                            <td>1 B</td>
                            <td>12.30 WIB</td>
                        </tr>
                        <tr class="info">
                            <td>3</td>
                            <td>1 C</td>
                            <td>12.30 WIB</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Departure History</div>
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
                    <tr>
                        <td>1</td>
                        <td>1 A</td>
                        <td>12.30 WIB</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>1 B</td>
                        <td>12.30 WIB</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>1 C</td>
                        <td>12.30 WIB</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1 A</td>
                        <td>12.30 WIB</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>1 B</td>
                        <td>12.30 WIB</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>1 C</td>
                        <td>12.30 WIB</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Current Stop</div>
            <div class="panel-body">
                <h4>Halte Jalan Kesehatan</h4>
                <h5>Capacity: 100 orang</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Weather</div>
            <div class="panel-body">
                <div class="col-md-4"><img src="img/clear_weather.png" style="width: 100%; " /></div>
                <div class="col-md-8"><h2><div id="temperature"><script type=text/javascript>initializeWeather("temperature", "-7.73", "110.37")</script></div></h2></div>
                <div class="col-md-12"><h4>40% rainy</h4></div>
            </div>
        </div>
    </div>

    <div class="col-md-6" style="word-wrap: break-word;">
        <div class="panel panel-default" style="word-wrap: break-word;">
            <div class="panel-heading">Info Terkini</div>
            <div class="panel-body">
                <div class="container">
                    <div class="date">Jumat, 20 Februari 2016 19.30 WIB</div>
                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie magna eu erat <br>elementum, a ullamcorper justo accumsan. Nullam tempus est ac bibendum volutpat.</div>
                    <hr />

                    <div class="date">Jumat, 20 Februari 2016 19.30 WIB</div>
                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie magna eu erat <br>elementum, a ullamcorper justo accumsan. Nullam tempus est ac bibendum volutpat.</div>
                    <hr>

                    <div class="date">Jumat, 20 Februari 2016 19.30 WIB</div>
                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie magna eu erat <br>elementum, a ullamcorper justo accumsan. Nullam tempus est ac bibendum volutpat.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div id="response_data">
    <h1>Waktu Kedatangan</h1>
    <p>3 menit</p>
</div>
--><?php /*echo csrf_token(); */?>

<script type="text/javascript" src="<?php echo URL::asset('js/angular.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
    $.material.init();
</script>
</body>
</html>