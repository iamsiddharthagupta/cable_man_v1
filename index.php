<?php

  session_start();

  if(isset($_SESSION['logged_staff'])) : header('Location: dashboard.php'); endif;

  require_once 'config/init.php';
  require_once 'includes/header.php';

  $msg = '';
  $code = '';

  if(isset($_POST['submit'])) {

    $username = $organ->escapeString(stripcslashes($_POST['username']));
    $password = $organ->escapeString(stripcslashes(md5($_POST['password'])));

    if(!empty($username) && !empty($password)) {

      $res = $organ->query("SELECT *, CONCAT(first_name,' ',last_name) AS logged_staff FROM tbl_staff WHERE username = '$username' AND password = '$password' LIMIT 1");

      $row = $res->fetch_assoc();

      if($res->num_rows > 0) {

        $_SESSION['staff_id'] = $row['staff_id'];
        $_SESSION['logged_staff'] = $row['logged_staff'];
        header('Location: dashboard.php');

      } else {

        $msg = 'Authentication Failed.';
        $code = 'danger';

      }

    } else {

        $msg = 'Please enter credentials.';
        $code = 'warning';

    }
  }

?>

<div class="hold-transition login-page">
  <div class="login-box">
  <div class="login-logo">
    <b>Cable</b>ERP
  </div>

  <div class="card card-outline card-primary">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Authorized Personnel Only.</p>

        <div class="alert alert-<?php echo $code; ?>" role="alert"><?php echo $msg; ?></div>

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