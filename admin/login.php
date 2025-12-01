<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Login";

include_once(ROOT_PATH . "/admin/layout/headerlogin.php");




?>

<body class="hold-transition login-page">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post" autocomplete="off">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="admin_email" placeholder="Email">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="admin_password" class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" name="admin_login" class="btn btn-primary btn-block btn-flat">Sign
              In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>



    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->


  <?php
  include(ROOT_PATH . "/admin/layout/footerlogin.php");

  ?>