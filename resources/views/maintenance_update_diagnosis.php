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
  <link href="<?php echo URL::asset('css/maintenance_update_diagnosis.css') ?>" type="text/css" rel="stylesheet">
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
<?php if(!isset($viewData['err_msg'])){ ?>
<?php $data_bus = $viewData['data_bus']; ?>
  <h2>Edit Bus Dalam Perbaikan</h2>
  <div class="col-md-10">
    <div class="input-form row">
      <form method="post" class="form-horizontal">
        <div class="form-group ui-widget">
          <label for="origin" class="col-sm-2">Plat Nomor</label>
          <div class="col-sm-8">
            <input type="text" name="plat_nomor" class="form-control" disabled value="<?php echo
            $data_bus['plat_nomor']; ?>">
            <!--<p class="form-control" disabled><?php /*echo $data_bus['plat_nomor']; */?></p>-->
          </div>
        </div>

        <div class="form-group ui-widget">
          <label for="destination" class="col-sm-2">Tanggal Masuk</label>
          <div class="col-sm-8">
            <input type="text" name="tgl_masuk" class="form-control" disabled value="<?php echo
            $data_bus['created_at']; ?>">
            <!--<p class="form-control" disabled><?php /*echo $data_bus['created_at']; */?></p>-->
          </div>
        </div>

        <div class="form-group ui-widget">
          <label for="maintainee" class="col-sm-2">ID Penanggung Jawab</label>
          <div class="col-sm-8">
            <p class="form-control" disabled><?php echo $data_bus['pic_id']; ?></p>
          </div>
        </div>

        <div class="form-group ui-widget">
          <label for="diagnosis" class="col-sm-2">Diagnosis Kerusakan</label>
          <div class="col-sm-8">
            <textarea class="form-control" rows="4" name="diagnosis"><?php echo $data_bus['diagnosis']; ?></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-4">
            <button type="submit" class="btn btn-default">Perbaharui Informasi</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } else { ?>
  <h2><?php echo $viewData['err_msg']; ?></h2>
<?php } ?>

<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
</body>
</html>