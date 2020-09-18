<?php
  
  // Setting up Indian timezone.
  date_default_timezone_set("Asia/Kolkata");  

  class Database {

      function __construct() {

        include 'connection.php';
        $this->conn = $conn;
      }
    }


  class User extends Database {

      public function profile_add_user() {

        if(isset($_POST['submit'])) {

          $first_name = mysqli_real_escape_string($this->conn,$_POST['first_name']);
          $last_name = mysqli_real_escape_string($this->conn,$_POST['last_name']);
          $phone_no = mysqli_real_escape_string($this->conn,$_POST['phone_no']);
          $area = mysqli_real_escape_string($this->conn,$_POST['area']);
          $address = mysqli_real_escape_string($this->conn,$_POST['address']);

          if(!empty($first_name) && !empty($phone_no) && !empty($address)){

          $sql = "INSERT INTO cbl_user
                    (first_name,last_name,phone_no,area,address)
                    VALUES
                    ('$first_name','$last_name','$phone_no','$area','$address')";

          if(mysqli_query($this->conn,$sql)){
           
            header('Location: user_profile_renewal.php?user_id='.mysqli_insert_id($this->conn));

          } else {

            $msg = 'Database Error.';
            header('Location: user_profile_add.php?msg='.$msg);
          
          }

        } else {

            $msg = 'Please Fill Details.';
            header('Location: user_profile_add.php?msg='.$msg);

        }
      }
    }











  }


// Counting Functions of Badges.

  function CountUser(){
    require 'connection.php';
    $query = "SELECT COUNT(user_id) AS total_users FROM cbl_user";
    $result = mysqli_query($conn,$query);
    $value = mysqli_fetch_assoc($result);
    $num_rows = $value['total_users'];
    return $num_rows;
  }

  function CountActiveUser($date){
    require 'connection.php';
    $query = "SELECT
              COUNT(DISTINCT user_id) AS active_user
              FROM cbl_ledger
              WHERE '$date' BETWEEN renew_date AND expiry_date";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['active_user'];
    }


  function CountActiveDevice($date){
    require 'connection.php';
    $query = "SELECT
              COUNT(DISTINCT dev_id) AS active_dev FROM cbl_ledger
              WHERE '$date' BETWEEN renew_date AND expiry_date";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['active_dev'];
  }

  function CountUnpaid(){
    require 'connection.php';
    $query = "SELECT COUNT(user_id) AS count_unpaid FROM cbl_ledger
              WHERE ledger_status = 'Renewed'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_unpaid'];
  }

   function CountPaid(){
    require 'connection.php';
    $query = "SELECT COUNT(ledger_id) AS count_paid FROM cbl_ledger WHERE ledger_status = 'Paid'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_paid'];
  }

  function CountExpiring($date){
    require 'connection.php';
    $query = "SELECT COUNT(ledger_id) AS count_expiring FROM cbl_ledger WHERE expiry_date = '$date'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_expiring'];
  }

  function CountDateColl($date){
    require 'connection.php';
    $query = "SELECT SUM(pay_amount) AS pay_amount FROM cbl_ledger WHERE pay_date = '$date'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['pay_amount'];
  }

    function CountRecentUser($curr_date){

    require 'connection.php';
    $date = date_create($curr_date);
    date_sub($date,date_interval_create_from_date_string("1 Month"));
    $back_date = date_format($date,"Y-m-d");

    $query = "SELECT COUNT(user_id) AS count_recent
              FROM cbl_user
              WHERE doi BETWEEN '$back_date' AND '$curr_date'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_recent'];
    }


    function CountRecentRenew($date){
    require 'connection.php';
    $query = "SELECT COUNT(user_id) AS recent_renew FROM cbl_ledger WHERE renew_date = '$date'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['recent_renew'];
  }

// Dynamic Query Functions for Sidebar Lists.

  function UserList(){

    $query = "GROUP BY cbl_user.user_id ORDER BY cbl_user.doi DESC";

    return urlencode($query);
  }

  function UserActiveList($user_status){

  $query = "WHERE cbl_user.user_status = '$user_status' GROUP BY cbl_user.user_id ORDER BY cbl_user.doi DESC";

  return urlencode($query);
}

  function ActiveList($user_status){

    $query = "WHERE cbl_user.user_status = '$user_status' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY expiry_date ASC";

    return urlencode($query);
  }

  function OverdueList($ledger_status){

    $query = "WHERE cbl_ledger.ledger_status = '$ledger_status' GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  }

    function PaidList($ledger_status){

    $query = "WHERE cbl_ledger.ledger_status = '$ledger_status' AND cbl_ledger.renew_term = 1 GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  }

    function SchemeList($ledger_status){

    $query = "WHERE cbl_ledger.ledger_status = '$ledger_status' AND cbl_ledger.renew_term > 1 GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  }

    function ExpiringList($date){

    $query = "WHERE cbl_ledger.expiry_date = '$date' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY expiry_date ASC";

    return urlencode($query);
  }

  // Dinamic Filter Function in User List.
    function UserFilter($area){

    $query = "WHERE cbl_user.area = '$area' GROUP BY cbl_user.user_id ORDER BY address ASC";

    return urlencode($query);
  }

  // Dinamic Filter Function in Active List.
    function ActiveFilter($area){

    $query = "WHERE cbl_user.area = '$area' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY cbl_ledger.expiry_date ASC,cbl_user.address ASC";

    return urlencode($query);
  }

  // Dinamic Filter Function in User List.
    function OverdueFilter($area){

    $query = "WHERE cbl_ledger.ledger_status = 'Renewed' AND cbl_user.area = '$area' GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC,cbl_user.address ASC";

    return urlencode($query);
  }

  function DailyCollMonth($date){

    $query = "WHERE cbl_ledger.pay_date = '$date' AND cbl_ledger.ledger_status = 'Paid' AND cbl_ledger.renew_term = 1 GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  
  }

    function DailyCollScheme($date){

    $query = "WHERE cbl_ledger.pay_date = '$date' AND cbl_ledger.ledger_status = 'Paid' AND cbl_ledger.renew_term > 1 GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  
  }

    function RecentUser($curr_date){

    $date = date_create($curr_date);
    date_sub($date,date_interval_create_from_date_string("1 Month"));
    $back_date = date_format($date,"Y-m-d");
    
    $query = "WHERE cbl_user.doi BETWEEN '$back_date' AND '$curr_date' AND cbl_user.user_status = 'ac' GROUP BY cbl_user.user_id ORDER BY cbl_user.doi DESC";
    return urlencode($query);
  }


  function RecentRenew($date){

    $query = "WHERE cbl_ledger.renew_date = '$date' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY expiry_date ASC";

    return urlencode($query);

  }

  // Including Navbar and Sidebar

  require_once 'assets/top-nav.php';
  require_once 'assets/side-nav.php'; 

?>