<?php

    session_start();

    if(isset($_SESSION['logged_staff'])) : header('Location: dashboard.php'); endif;

    require_once 'config/init.php';
    require_once 'includes/header.php';

    $security->login();

?>

<div class="hold-transition login-page">
  <div class="login-box">
  <div class="login-logo">
    <b>Cable</b>ERP
  </div>

  <div class="card card-outline card-primary">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Authorized Personnel Only.</p>

          <?php if(isset($_GET['msg'], $_GET['code'])){ ?>
            <div class="alert alert-<?php echo $_GET['code']; ?>" role="alert"><?php echo $_GET['msg']; ?></div>
          <?php } ?>

      <form method="POST">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>

        </div>
      </form>
  </div>
</div>

</div>
</div>

</html>