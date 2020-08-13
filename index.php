<?php require_once 'common/header.php'; ?>

<div class="hold-transition login-page">
  <div class="login-box">
<!-- Login Form-->
  <div class="login-logo">
    <b>Cable</b>ERP
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

          <?php if(isset($_GET['msg'])){ ?>
            <div class="alert alert-primary" role="alert"><?php echo $_GET['msg']; ?></div>
          <?php } ?>

      <form method="POST" action="<?php echo htmlspecialchars('login_process.php'); ?>">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo isset($_POST['username']) ? $username : ''; ?>" autofocus>
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
          <!-- /.col -->
        </div>
      </form>
  </div>
</div>
<!-- /.login-box -->  
</div>
</div>

</html>