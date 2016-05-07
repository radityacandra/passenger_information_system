<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>All Bus in Operation</title>

  <link href="<?php echo URL::asset('css/font-awesome-4.5.0/css/font-awesome.min.css'); ?>" type="text/css"
        rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/route_planner.css') ?>" type="text/css" rel="stylesheet">

  <link href="<?php echo URL::asset('js/jquery-ui-1.11.4.custom/jquery-ui.css') ?>" type="text/css" rel="stylesheet">
  <script src="<?php echo URL::asset('js/jquery-ui-1.11.4.custom/jquery-ui.js') ?>"></script>
  <script>
    $(function(){
      var availableBusStop = <?php echo json_encode($viewData['all_bus']); ?>;

      $("#input1").autocomplete({
        source: availableBusStop
      });

      $("#input2").autocomplete({
        source: availableBusStop
      });
    });
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
          <li><a href="javascript:void(0)" style="font-size: x-large; ">Smart Passenger Information System</a></li>
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
                <i class="fa fa-map-o"></i> Map View
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
                <i class="fa fa-bus"></i> Bus Operation
              </a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <ul class="list-group" style="color: #000000; ">
              <li><i class="fa fa-bus"></i> Semua Bus Operasi</li>
              <li><i class="fa fa-bus"></i> Semua Bus Perbaikan</li>
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
                <i class="fa fa-list"></i> Arrival Schedule
              </a>
            </h4>
          </div>
          <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <ul class="list-group" style="color: #000000; ">
              <li><a href="<?php echo url('arrival_schedule') ?>"><i class="fa fa-list"></i> Semua Jadwal
                  Kedatangan</a></li>
              <li><i class="fa fa-search"></i> Filter Jadwal Kedatangan</li>
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
                <i class="fa fa-expand"></i> Route Planner
              </a>
            </h4>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>

<!--content-->
<h2>Perencana Rute Perjalanan</h2>
<div class="col-md-10">
  <div class="input-form row">
    <form method="post">
      <div class="form-group label-floating is-empty ui-widget">
        <label for="origin" class="control-label">Masukkan Halte Awal</label>
        <input type="text" class="form-control" name="origin" id="input1">
      </div>

      <div class="form-group label-floating is-empty ui-widget">
        <label for="destination" class="control-label">Masukkan Halte Tujuan</label>
        <input type="text" class="form-control" name="destination" id="input2">
      </div>

      <button type="submit" class="form-control">Cari Rute</button>
    </form>
  </div>

  <?php if(isset($viewData['total_time'])){ ?>
    <div class="output-rute row">
      <h2>Rekomendasi Perjalanan</h2>
      <h4>Total Waktu: <?php echo $viewData['total_time'] ?></h4>
      <h4>Total Transit: <?php echo sizeof($viewData['route']) - 1; ?></h4>
      <h4>Rute:</h4>

      <table class="table table-striped table-hover">
        <thead>
        <tr>
          <td>Dari Halte</td>
          <td>Ke Halte</td>
          <td>Rute</td>
          <td>Waktu Tunggu</td>
          <td>Waktu Tempuh</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($viewData['route'] as $route){
          echo '<tr>';
          echo '<td>'.$route['detail_origin']['nama_halte'].'</td>';
          echo '<td>'.$route['detail_destination']['nama_halte'].'</td>';
          echo '<td>'.$route['rute_id'].'</td>';
          if(isset($route['waiting_time'])&&isset($route['travel_time'])){
            echo '<td>'.$route['waiting_time'].'</td>';
            echo '<td>'.$route['travel_time'].'</td>';
          } else {
            echo '<td>belum ada perkiraan bus yang akan datang</td>';
            echo '<td>belum ada perkiraan bus yang akan datang</td>';
          }
          echo '</tr>';
        }
        ?>
        </tbody>
      </table>
    </div>
  <?php } ?>
</div>

<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
</body>
</html>