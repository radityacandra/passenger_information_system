<!doctype html>
<html ng-app>
<head>
  <title>Dashboard Transjogja</title>

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
  <?php echo Html::style('css/home_bus_detail.css'); ?>

  <script>
    //for timer
    deadline = 3600;

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
      <div class="panel-heading">Incoming Bus (delay)</div>
      <div class="panel-body">
        <h1>Rute A</h1>
        <h5>in</h5>
        <h2><div id="clock"><script type="text/javascript">initializeClock('clock')</script></div></h2>
        <table class="table table-striped table-hover">
          <tr>
            <td>Current Speed</td>
            <td>:</td>
            <td>40 kmph</td>
          </tr>
          <tr>
            <td>Next Stop</td>
            <td>:</td>
            <td>Halte Jalan Cik Di Tiro</td>
          </tr>
          <tr>
            <td>Driver Name</td>
            <td>:</td>
            <td>Supardi</td>
          </tr>
          <tr>
            <td>Plat Nomor</td>
            <td>:</td>
            <td>AB 1524 BA</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">Arrival Schedule</div>
      <div class="panel-body">
        <table class="table table-striped table-hover">
          <thead>
          <tr>
            <th>#</th>
            <th>Nomor Rute</th>
            <th>Waktu Kedatangan</th>
            <th>Arrival In</th>
          </tr>
          </thead>
          <tbody>
          <tr class="info">
            <td>1</td>
            <td>1 A</td>
            <td>12.30 WIB</td>
            <td>1h 3m 59s</td>
          </tr>
          <tr class="info">
            <td>2</td>
            <td>1 B</td>
            <td>12.30 WIB</td>
            <td>1h 3m 59s</td>
          </tr>
          <tr class="info">
            <td>3</td>
            <td>1 C</td>
            <td>12.30 WIB</td>
            <td>1h 3m 59s</td>
          </tr>
          <tr class="info">
            <td>1</td>
            <td>1 A</td>
            <td>12.30 WIB</td>
            <td>1h 3m 59s</td>
          </tr>
          <tr class="info">
            <td>2</td>
            <td>1 B</td>
            <td>12.30 WIB</td>
            <td>1h 3m 59s</td>
          </tr>
          <tr class="info">
            <td>3</td>
            <td>1 C</td>
            <td>12.30 WIB</td>
            <td>1h 3m 59s</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!--container 2nd row-->
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">Current Total Operating Bus</div>
      <div class="panel-body">
        <h2>150 Bus in 150 Rute</h2>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">Current Total Maintenance</div>
      <div class="panel-body">
        <h2>50 Bus in 10 Rute</h2>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo URL::asset('js/angular.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
</body>
</html>