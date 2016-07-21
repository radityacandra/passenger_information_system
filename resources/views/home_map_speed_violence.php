<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>Monitoring Bus Beroperasi</title>

  <link href="<?php echo URL::asset('css/font-awesome-4.5.0/css/font-awesome.min.css'); ?>" type="text/css"
        rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/home_big_map.css') ?>" type="text/css" rel="stylesheet">
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
          <li><a href="javascript:void(0)" style="font-size: x-large; ">Sistem Informasi Penumpang Bus</a></li>
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

<!--sidebar-->
<div class="col-md-2 sidebar">
  <ul>
    <li>
      <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" href="<?php echo url('map_bus');
              ?>"
                 aria-expanded="true" aria-controls="collapseOne">
                <i class="fa fa-map-o"></i> Monitoring Bus
              </a>
            </h4>
          </div>
        </div>
      </div>
    </li>

    <li>
      <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo"
                 aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa fa-bus"></i> Bus Beroperasi
              </a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <ul class="list-group" style="color: #000000; ">
              <li><a href="<?php echo url('list_bus/operation'); ?>"><i class="fa fa-bus"></i> Semua Bus
                  Operasi</a></li>
              <li><a href="<?php echo url('list_bus/maintenance'); ?>"><i class="fa fa-bus"></i> Semua Bus
                  Perbaikan</a></li>
              <li><a href="<?php echo url('daftar_bus'); ?>"><i class="fa fa-plus"></i> Registrasi Bus</a></li>
            </ul>
          </div>
        </div>
      </div>
    </li>

    <li>
      <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree"
                 aria-expanded="false" aria-controls="collapseThree">
                <i class="fa fa-home"></i> Halte
              </a>
            </h4>
          </div>
          <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <ul class="list-group" style="color: #000000; ">
              <li><a href="<?php echo url('list_halte'); ?>"><i class="fa fa-home"></i> Semua Halte</a></li>
              <li><a href="<?php echo url('daftar_halte'); ?>"><i class="fa fa-plus"></i> Tambah Halte</a></li>
            </ul>
          </div>
        </div>
      </div>
    </li>

    <li>
      <div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingFour">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour"
                 aria-expanded="false" aria-controls="collapseFour">
                <i class="fa fa-list"></i> Kedatangan Bus
              </a>
            </h4>
          </div>
          <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <ul class="list-group" style="color: #000000; ">
              <li><a href="<?php echo url('arrival_schedule') ?>"><i class="fa fa-list"></i> Semua Jadwal
                  Kedatangan</a></li>
            </ul>
          </div>
        </div>
      </div>
    </li>

    <li>
      <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" href="<?php echo url('route_planner');
              ?>"
                 aria-expanded="true" aria-controls="collapseOne">
                <i class="fa fa-expand"></i> Perencana Perjalanan
              </a>
            </h4>
          </div>
        </div>
      </div>
    </li>

    <li>
      <div class="panel-group" id="accordion5" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingFive">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseFive"
                 aria-expanded="false" aria-controls="collapseFive">
                <i class="fa fa-smile-o"></i> Evaluasi
              </a>
            </h4>
          </div>
          <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
            <ul class="list-group" style="color: #000000; ">
              <li><a href="<?php echo url('feedback/bus_stop') ?>"><i class="fa fa-home"></i> Feedback Halte</a></li>
              <li><a href="<?php echo url('feedback/bus'); ?>"><i class="fa fa-bus"></i> Feedback Bus</a></li>
            </ul>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>

<!--content-->
<div class="col-md-10">
  <div id="map" style="height: 550px"></div>
</div>

<!--filter area-->
<div class="col-md-12" id="filter">
  <div class="panel panel-default">
    <div class="panel-heading">Filter</div>
    <div class="panel-body">
      <form action="" onsubmit="customSubmit(); return false;">
        <div class="col-md-4">
          <div class="form-group label-floating is-empty">
            <label for="plat_nomor" class="control-label">Masukkan Plat Nomor (Opsional)</label>
            <input type="text" name="plat_nomor" class="form-control" />
          </div>

          <div class="form-group label-floating is-empty">
            <label for="rute_id" class="control-label">Masukkan Rute (Opsional)</label>
            <input type="text" name="rute_id" class="form-control" />
          </div>
        </div>
        <div class="col-md-4">
          <input type="submit" name="current_position" class="form-control" onclick="display_option='current_position';"
                 value="Posisi Saat Ini Bus">
          <input type="submit" name="trace_position" class="form-control" onclick="display_option='trace_position';"
                 value="Histori Perjalanan Bus">
        </div>
        <div class="col-md-4">
          <input type="submit" name="speed_violence" class="form-control" onclick="display_option='speed_violence';"
                 value="Histori Pelanggaran Kecepatan">
          <input type="submit" name="route_based" class="form-control" onclick="display_option='route_based'"
                 value="Cari Berdasarkan Rute">
        </div>
      </form>
    </div>
  </div>
</div>

<?php if(isset($viewData['speed_violation'])){ ?>
  <?php if (isset($viewData['speed_violation'][0]['violation_id'])) { ?>
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Violation ID</th>
            <th>Plat Nomor</th>
            <th>Status Pelanggaran</th>
            <th>Kecepatan Pelanggaran</th>
            <th>Pelanggaran ke-</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $listViolation = $viewData['speed_violation'];
          foreach($listViolation as $speedViolation){
            echo '<tr>';
            echo '<td>'.$speedViolation['violation_id'].'</td>';
            echo '<td>'.$speedViolation['plat_nomor'].'</td>';
            if($speedViolation['on_violation']==1){
              echo '<td>Sedang Melanggar</td>';
            } else {
              echo '<td>Sedang Tidak Melanggar</td>';
            }
            echo '<td>'.$speedViolation['speed_violation'].'</td>';
            echo '<td>'.$speedViolation['count_violation'].'</td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php } else{ ?>
    <div class="col-md-12">
      <h3 style="text-align:center;">Bus Belum Pernah Melakukan Pelanggaran</h3>
    </div>
  <?php } ?>
<?php } ?>

<?php if(isset($viewData['list_route'])){ ?>
  <?php if (isset($viewData['list_route'][0]['plat_nomor'])) { ?>
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Plat Nomor</th>
            <th>Rute ID</th>
            <th>Kecepatan Rata-rata</th>
            <th>ID Supir</th>
            <th>ID Kondektur</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $listRoute = $viewData['list_route'];
          foreach($listRoute as $busRoute){
            echo '<tr>';
            echo '<td>'.$busRoute['plat_nomor'].'</td>';
            echo '<td>'.$busRoute['rute_id'].'</td>';
            echo '<td>'.$busRoute['avg_speed'].'</td>';
            if($busRoute['driver_id']!=null){
              echo '<td>'.$busRoute['driver_id'].'</td>';
            } else {
              echo '<td>(Data tidak dimasukkan)</td>';
            }
            if($busRoute['conductor_id']!=null){
              echo '<td>'.$busRoute['conductor_id'].'</td>';
            } else {
              echo '<td>(Data tidak dimasukkan)</td>';
            }
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php } else{ ?>
    <div class="col-md-12">
      <h3 style="text-align:center;">Tidak Ada Bus Yang Beroperasi Pada Rute Tersebut</h3>
    </div>
  <?php } ?>
<?php } ?>

<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>

<script type="text/javascript">
  var rute_id;
  var plat_nomor;
  var display_option;
  function customSubmit(){
    plat_nomor = document.getElementsByName("plat_nomor")[0].value;
    rute_id = document.getElementsByName("rute_id")[0].value;

    <?php

      if(getenv('APP_ENV') == 'local'){
        echo 'window.location.href = "http://localhost/pis/map_bus?plat_nomor="+plat_nomor+"&rute_id="+rute_id+"&display="+display_option';
      }

      if(getenv('APP_ENV') == 'production'){
        echo 'window.location.href = "http://smartcity.wg.ugm.ac.id/webapp/passenger_information_system/public/map_bus?plat_nomor="+plat_nomor+"&rute_id="+rute_id+"&display="+display_option';
      }

    ?>
  }
</script>

<script type="text/javascript">
  <?php
    if (getenv('APP_ENV') == 'local') {
      echo "var baseUrl = 'http://localhost/pis/api/';";
    }

    if(getenv('APP_ENV') == 'production'){
      echo 'var baseUrl = "http://smartcity.wg.ugm.ac.id/webapp/passenger_information_system/public/api/';
    }
  ?>
  var url, uri;

  function initMap(){
    var centerLatLng = {lat:-7.801381, lng:110.364791};

    var map = new google.maps.Map(document.getElementById('map'), {
      center: centerLatLng,
      scrollWheel: false,
      zoom: 13
    });

    setMarker(map);
  }

  function setMarker(map){
    if (getParameterByName('display') == 'speed_violence' && getParameterByName('plat_nomor') != null){
      uri = 'bus/operation/'+getParameterByName('plat_nomor');
      url = baseUrl+uri;

      //do polling to display marker
      (function pollingMarker(){
        setTimeout(function(){
          $.ajax({
            url: url,
            type: "GET",
            success: function(data){
              if (data.code == 200){
                if (data.data.last_latitude!=null && data.data.last_longitude!=null){
                  var positionBus = {lat: Number(data.data.last_latitude), lng: Number(data.data.last_longitude)};
                  var bus = new google.maps.Marker({
                    position: positionBus,
                    title: data.data.plat_nomor
                  });
                  bus.setMap(map);
                }
              }
            },
            dataType: "json",
            complete: pollingMarker,
            timeout: 2000
          })
        }, 3000);
      })();
    }

    if (getParameterByName('display') == 'route_based' && getParameterByName('rute_id') != null){
      uri = 'bus/route/'+getParameterByName('rute_id');
      url = baseUrl+uri;

      //do polling to display marker
      (function pollingMarker(){
        setTimeout(function(){
          $.ajax({
            url: url,
            type: "GET",
            success: function(data){
              if (data.code == 200){
                for (i = 0; i<data.data.length; i++){
                  if (data.data[i].last_latitude!=null && data.data[i].last_longitude!=null){
                    var positionBus = {lat: Number(data.data[i].last_latitude), lng: Number(data.data[i].last_longitude)};
                    var bus = new google.maps.Marker({
                      position: positionBus,
                      title: data.data[i].plat_nomor
                    });
                    bus.setMap(map);
                  }
                }
              }
            },
            dataType: "json",
            complete: pollingMarker,
            timeout: 2000
          })
        }, 3000);
      })();
    }
  }

  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU&callback=initMap"></script>
</body>
</html>
