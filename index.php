<?php
// Do not use this session in any page from here. Use rest of the page's session code.
    session_start();
    if(isset($_SESSION['curr_user'])){
        header('location:dashboard.php');
    }
    include '../common/header.php';
    include '../common/connection.php';
?>

<style type="text/css">
 html,body {
  height: 100%;
}

body {
  text-align: center;
  display: -ms-flexbox;
  display: -webkit-box;
  display: flex;
  -ms-flex-align: center;
  -ms-flex-pack: center;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}
</style>

<!-- Php Script for Login form Validation-->

<?php
  $msg = '';
  $msgClass = '';

  if(filter_has_var(INPUT_POST, 'submit')){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
// Hashing Passkeys    
    $password = md5($password);

    if(!empty($username) && !empty($password)){

      $query = "SELECT * FROM tbl_auth WHERE `username` = '$username' AND `password` = '$password'";
      $result = mysqli_query($conn,$query);
      $row = mysqli_num_rows($result);
      if ($row < 1) {
        $msg = 'Username or Password is Invalid!';
        $msgClass = 'alert-danger';
      } else {
        $data = mysqli_fetch_assoc($result);
        $full_name = $data['full_name'];
        $_SESSION['curr_user'] = $full_name;
        header('location:dashboard.php');
      }
      } else {
        $msg = 'Please enter credentials!';
        $msgClass = 'alert-warning';
      }
  }

?>

<!-- Login Form-->

  <form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <?php if($msg != ''): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
      <?php endif; ?>

      <h1 class="h3 mb-3 font-weight-normal">Cable ERP :: Login</h1>
        <label class="sr-only">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $username : ''; ?>" autofocus>
        <label class="sr-only">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
        <button class="btn btn-block btn-outline-primary" type="submit" name="submit">Login</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2019-<?php echo date("Y") ?></p>
  </form>
  
  </body>
</html>