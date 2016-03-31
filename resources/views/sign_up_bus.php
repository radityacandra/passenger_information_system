<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>Input Data Bus</title>

  <link href="<?php echo URL::asset('css/sign_up_bus.css') ?>" type="text/css" rel="stylesheet">
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="left col-md-6">
    <h1>Input Data Bus</h1>
    <p><b>Untuk memasukkan data bus ke database,<br> Silahkan inputkan data dengan cermat, tepat, dan teliti</b></p>
  </div>

  <div class="right col-md-6">
    <h2>Form Register Bus</h2>
    <form method="post">
      <div class="form-group label-floating is-empty">
        <label for="plat_nomor" class="control-label">Plat Nomor</label>
        <input type="text" name="plat_nomor" class="form-control" />
      </div>

      <div class="form-group label-floating is-empty">
        <label class="control-label" for="rute">Rute Bus</label>
        <input type="text" name="rute" class="form-control" />
      </div>

      <div class="form-group label-floating is-empty">
        <label for="device_id" class="control-label">Device Identifier Bus</label>
        <input type="text" name="device_id" class="form-control" />
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