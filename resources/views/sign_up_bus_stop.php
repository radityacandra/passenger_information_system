<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>Input Data Halte Bus</title>

  <link href="<?php echo URL::asset('css/sign_up_bus_stop.css') ?>" type="text/css" rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
</head>

<body>
<div class="left col-md-6">
  <h1>Input Data Halte Bus</h1>
  <p><b>Untuk memasukkan data bus ke database,<br> Silahkan inputkan data dengan cermat, tepat, dan teliti</b></p>
</div>

<div class="right col-md-6">
  <h2>Form Register Halte</h2>
  <form method="post">
    <div class="form-group label-floating is-empty">
      <label for="nama_halte" class="control-label">Nama Halte</label>
      <input type="text" name="nama_halte" class="form-control" />
    </div>

    <div class="form-group label-floating is-empty">
      <label class="control-label" for="alamat_halte">Alamat Halte</label>
      <input type="text" name="alamat_halte" class="form-control" />
    </div>

    <div class="form-group label-floating is-empty">
      <label for="latitude" class="control-label">Lokasi Latitude Halte</label>
      <input type="text" name="latitude" class="form-control" />
    </div>

    <div class="form-group label-floating is-empty">
      <label for="longitude" class="control-label">Lokasi Longitude Halte</label>
      <input type="text" name="longitude" class="form-control" />
    </div>

    <input type="submit" class="btn" value="kirim">
  </form>
</div>

<script type="text/javascript" src="<?php echo URL::asset('js/material_js/material.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/material_js/ripples.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('js/bootstrap_js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
  $.material.init();
</script>
</body>
</html>
