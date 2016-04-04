<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>Detail Jadwal Kedatangan</title>

  <link href="<?php echo URL::asset('css/home_arrival_estimation.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/font-awesome-4.5.0/css/font-awesome.min.css'); ?>" type="text/css"
        rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">

  <script>
    //for timer
    deadline = <?php echo $arrivalEstimation['waktu_kedatangan']; ?>;

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
      var t = getTimeRemaining(deadline);
      divClock.innerHTML = t.hours + ' jam ' + t.minutes + ' menit ' + t.seconds +' detik ';

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
    //for distance
    var totalDistance = <?php echo $arrivalEstimation['jarak']; ?>;
    function initializeDistance(id){
      var divDistance = document.getElementById(id);
      var kilo = Math.floor(totalDistance/1000);
      var meter = Math.floor(totalDistance%1000);

      divDistance.innerHTML = kilo + ' Kilometer ' + meter + ' Meter.';
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
          <li><a href="javascript:void(0)" style="font-size: x-large; ">Home > Detail Arrival Estimation</a></li>
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

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        Arrival Estimation
      </div>
      <div class="panel-body">
        <h3>Kode kedatangan <?php echo $arrivalEstimation['arrival_code']; ?></h3>
        <h3><?php echo 'Rute ' . $arrivalEstimation['rute_id'] ?></h3>
        <h4>akan datang pada</h4>
        <h3 id="clock"><script type=text/javascript>initializeClock('clock')</script></h3>
        <h3 id="distance"><script type="text/javascript">initializeDistance('distance')</script></h3>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        Detail Bus
      </div>
      <div class="panel-body">
        <h4>Plat Nomor</h4>
        <h3><?php echo $arrivalEstimation['plat_nomor']; ?></h3>
        <table class="table table-striped table-hover">
          <tr>
            <td>Current Speed</td>
            <td>:</td>
            <td>40 kmph</td>
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
</div>

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        Halte Asal
      </div>
      <div class="panel-body">
        <?php
        if(isset($arrivalEstimation['this_halte']['nama_halte'])){
          echo '<h3>' . $arrivalEstimation['this_halte']['nama_halte'] . '</h3>';
          echo '<h4>' . $arrivalEstimation['this_halte']['lokasi_halte']. '</h4>';
          echo '<h4><a href="http://maps.google.com/?q='.$arrivalEstimation['this_halte']['latitude'].','
              .$arrivalEstimation['this_halte']['longitude'].'&output=embed"
          onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\');
          return false;">'.$arrivalEstimation['this_halte']['latitude'].', '
              .$arrivalEstimation['this_halte']['longitude'].'</a></h4>';
        } else{
          echo '<h3>Bus baru keluar dari garasi, tidak ada informasi halte asal</h3>';
        }
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        Halte Tujuan
      </div>
      <div class="panel-body">
        <?php echo '<h3>' . $arrivalEstimation['to_halte']['nama_halte'] . '</h3>'; ?>
        <?php echo '<h4>' . $arrivalEstimation['to_halte']['lokasi_halte']. '</h4>'; ?>
        <?php echo '<h4><a href="http://maps.google.com/?q='.$arrivalEstimation['to_halte']['latitude'].','
            .$arrivalEstimation['to_halte']['longitude'].'&output=embed"
          onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\');
          return false;">'.$arrivalEstimation['to_halte']['latitude'].', '
            .$arrivalEstimation['to_halte']['longitude'].'</a></h4>'; ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
</body>
</html>