<!doctype html>
<html>
<head>
  <script type="text/javascript" src="<?php echo URL::asset('js/jquery-1.12.0.min.js') ?>"></script>
  <title>Login to Admin Area</title>

  <link rel="stylesheet" href="<?php echo URL::asset('css/dashboard_login.css'); ?>" type="text/css" />
  <link href="<?php echo URL::asset('css/material_css/bootstrap-material-design.min.css') ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo URL::asset('css/material_css/ripples.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo URL::asset('css/bootstrap_css/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css">

</head>

<body>
  <div id="logo" class="container col-md-4 col-md-offset-4">
    <img src="<?php echo URL::asset('img/logo.gif') ?>" width="150" />
  </div>

  <div id="container" class="container col-md-4 col-md-offset-4">
    <div id="header">
      <h1>Login</h1>
    </div>

    <div id="content">
      <form method="post">
        <?php
        foreach($errors->all() as $error){
          echo $error;
        }
        ?>

        <div class="form-group label-floating is-empty">
          <label for="input_email" class="control-label">Alamat Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo old('email'); ?>">
          <span class="help-block">Tolong masukkan email address yang valid</span>
        </div>

        <div class="form-group label-floating is-empty">
          <label for="input_password" class="control-label">Password</label>
          <input type="password" class="form-control" name="password">
        </div>
				
	      <div class="form-group">
		      <input type="checkbox" name="remember"> Remember Me
		      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	      </div>
	      
        <button type="submit" class="btn">Masuk</button>
      </form>
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
