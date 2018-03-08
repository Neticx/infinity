<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Bimbel Infinity</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('/assets/vendors/bootstrap/dist/css/'); ?>bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('/assets/vendors/font-awesome/css/'); ?>font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('/assets/vendors/nprogress/'); ?>nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url('/assets/vendors/animate.css/'); ?>animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('/assets/build/css/'); ?>custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form role="form" autocomplete="off" method="post" action="">
              <h1>Login Form</h1>
              <?php if(!empty($alert)){ ?>
                <div class="alert bg-danger" role="alert">
                  <i class="fa fa-ban"></i> <?php echo $alert;?>
                </div>
              <?php } ?>
              <div>
                <input class="form-control" placeholder="Email" name="email" type="email" autofocus="" required="">
              </div>
              <div>
                <input class="form-control" placeholder="Password" name="password" type="password" value="" required="">
              </div>
              <div>
                <button type="submit" class="btn btn-danger submit">LOGIN</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-graduation-cap"></i> Bimbel Infinity!</h1>
                  <p>©2017 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url('/assets/vendors/jquery/dist/'); ?>jquery.min.js"></script>
    <script src="<?php echo base_url('/assets/vendors/bootstrap/dist/js/'); ?>bootstrap.min.js"></script>
  </body>
</html>