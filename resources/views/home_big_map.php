<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>All Bus in Operation</title>

  <link href="<?php echo URL::asset('css/home_big_map.css') ?>" type="text/css" rel="stylesheet">
  <link href="<?php echo URL::asset('css/font-awesome-4.5.0/css/font-awesome.min.css'); ?>" type="text/css"
        rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvyyijm6cgfQmrd5Sn-T8OltJdK4WkRQ8&callback=initMap"></script>
  <script type="text/javascript">
    function initMap(){
      var centerLatLng = {lat:-7.801381, lng:110.364791};

      var map = new google.maps.Map(document.getElementById('map'), {
        center: centerLatLng,
        scrollWheel: false,
        zoom: 13
      });

      <?php
      $counter = 1;
      foreach($viewData['all_bus'] as $busOperation){
        echo 'var positionBus'.$counter.' = {lat:'.$busOperation['last_latitude'].', lng:'
        .$busOperation['last_longitude'].'};';
        echo 'var bus = new google.maps.Marker({';
        echo 'map: map,';
        echo 'position: positionBus'.$counter.',';
        echo 'title: "' . $busOperation['plat_nomor'] . '"';
        echo '});';
        $counter++;
      }
      ?>
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
                <li><i class="fa fa-bus"></i> Bus Operation</li>
                <li><i class="fa fa-bus"></i> Bus Operation</li>
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
                <li><i class="fa fa-bus"></i> Bus Operation</li>
                <li><i class="fa fa-bus"></i> Bus Operation</li>
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
                <li><i class="fa fa-bus"></i> Bus Operation</li>
                <li><i class="fa fa-bus"></i> Bus Operation</li>
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

  <script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
  <script type="text/javascript">
    $.material.init();
  </script>
</body>
</html>