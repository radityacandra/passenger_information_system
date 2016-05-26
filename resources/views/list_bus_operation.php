<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>Semua Bus yang sedang beroperasi</title>

  <link href="<?php echo URL::asset('css/font-awesome-4.5.0/css/font-awesome.min.css'); ?>" type="text/css"
        rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/list_bus_operation.css') ?>" type="text/css" rel="stylesheet">
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
        <a class="navbar-brand" href="javascript:void(0)"><img src="<?php echo URL::asset('img/logo.gif'); ?>"
                                                               width="50" /></a>
      </div>
      <div class="navbar-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
          <li><a href="javascript:void(0)" style="font-size: x-large; ">Smart Passenger Information System</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo URL::asset('img/ic_settings_white_24dp_1x.png'); ?>"/>
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

    <li>
      <div class="panel-group" id="accordion5" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingFive">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapseFive"
                 aria-expanded="false" aria-controls="collapseFive">
                <i class="fa fa-smile-o"></i> User Feedback
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

<!--container-->
<div class="col-md-10">
  <h2>Informasi Bus Yang Sedang Beroperasi</h2>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <td>No.</td>
        <td>Plat Nomor</td>
        <td>Rute Operasi</td>
        <td>Kecepatan Bus</td>
        <td>Lokasi</td>
        <td>Action</td>
      </tr>
    </thead>

    <tbody>
    <?php
    $counter = 1;
    foreach($viewData['all_bus'] as $busOperation){
      echo '<tr>';
      echo '<td>'.$counter.'.</td>';
      echo '<td>'.$busOperation['plat_nomor'].'</td>';
      echo '<td>'.$busOperation['rute_id'].'</td>';
      echo '<td>'.$busOperation['avg_speed'].'</td>';
      $queryUrl = 'lat='.$busOperation['last_latitude'].'&long='.$busOperation['last_longitude'].'&busid='.$busOperation['plat_nomor'];
      echo '<td>
              <a class="btn green" href="#" onclick="window.open('; echo "'"; echo url('full_map?').$queryUrl; echo "'".',';
      ?>'location','width=1100,height=520'<?php echo ')"><i class="fa fa-eye"></i> Lihat</a>
            </td>';
      echo '<td>
              <a class="btn blue" href="#"><i class="fa fa-cogs"> Perbaiki</i></a>
              <a class="btn red" href="#"><i class="fa fa-trash"> Hapus</i></a>
            </td>';
      echo '</tr>';
      $counter++;
    }
    ?>
    </tbody>
  </table>
</div>

<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
</body>
</html>