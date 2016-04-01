<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>List Halte Transjogja</title>

  <link href="<?php echo URL::asset('css/list_bus_stop.css') ?>" type="text/css" rel="stylesheet">
  <link href="<?php echo URL::asset('css/font-awesome-4.5.0/css/font-awesome.min.css'); ?>" type="text/css"
        rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
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

  <!--sidebar menu-->
  <div class="col-md-2 sidebar">
    <ul>
      <li><i class="fa fa-map-o"></i> Map View</li>
      <li><i class="fa fa-bus"></i> Bus Operation</li>
      <li><i class="fa fa-home"></i> Halte</li>
      <li><i class="fa fa-list"></i> Arrival Schedule</li>
    </ul>
  </div>

  <!--container-->
  <div class="col-md-10">
    <h2>Informasi Halte Transjogja</h2>
    <table class="table table-striped table-hover ">
      <thead>
      <tr>
        <th>#</th>
        <th>Nama Halte</th>
        <th>Lokasi Halte</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
      <?php
      $counter = 1;
      $listBusStop = $viewData['bus_stop'];
      foreach($listBusStop as $busStop){
        echo '<tr>';
        echo '<td>'.$counter.'</td>';
        echo '<td>'.$busStop['nama_halte'].'</td>';
        echo '<td>'.$busStop['lokasi_halte'].'</td>';
        echo '<td>';
        echo '<a class="btn green" href="'; echo url('home/'.$busStop['halte_id']); echo '"><i class="fa
        fa-eye"></i>Lihat</a>';
        echo '<a class="btn blue"><i class="fa fa-pencil"></i>Edit</a>';
        echo '<a class="btn red" href="'; echo url('delete_halte/'.$busStop['halte_id']); echo '"><i class="fa
        fa-trash"></i>Delete</a>';
        echo '</td>';
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