<?php
  
  // Setting up Indian timezone.
  date_default_timezone_set("Asia/Kolkata");  

  class Connection {

      function __construct() {

        include 'connection.php';
        $this->conn = $conn;
      }
    }


  class User extends Connection {

      public function user_profile_add() {

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
           
            header('Location: user_profile_device_map.php?user_id='.mysqli_insert_id($this->conn));

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

    public function user_profile_update() {

      if(isset($_POST['submit'])) {

        $first_name = mysqli_real_escape_string($this->conn,$_POST['first_name']);
        $last_name = mysqli_real_escape_string($this->conn,$_POST['last_name']);
        $phone_no = mysqli_real_escape_string($this->conn,$_POST['phone_no']);
        $area = mysqli_real_escape_string($this->conn,$_POST['area']);
        $address = mysqli_real_escape_string($this->conn,$_POST['address']);
        $user_status = mysqli_real_escape_string($this->conn,$_POST['user_status']);
        $user_id = $_POST['user_id'];

          $sql = "UPDATE cbl_user SET
          first_name = '$first_name',
          last_name = '$last_name',
          phone_no = '$phone_no',
          address = '$address',
          area = '$area',
          user_status = '$user_status'

          WHERE user_id = '$user_id'";

          if(mysqli_query($this->conn,$sql)){

              $msg = 'Profile Updation Successful.';
              header('Location: user_profile_update.php?user_id='.$user_id.'&msg='.$msg);

              } else {

              $msg = 'Database Error.';
              header('Location: user_profile_update.php?user_id='.$user_id.'&msg='.$msg);
          }
        }
      }

    public function user_list() {

      $sql ="
              SELECT
              u.user_id,
              u.first_name,
              u.last_name,
              u.phone_no,
              u.address,
              u.area,
              u.user_status,
              SUM(d.package) AS package,
              COUNT(ud.dev_id) AS device_count,
              ud.dev_id,
              CASE
                WHEN ud.dev_id IS NULL THEN 'Device Unmapped'
                WHEN u.user_status = 0 THEN 'Inactive'
                WHEN u.user_status = 1 THEN 'Active'
              END AS user_status

              FROM cbl_user_dev ud

              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
              GROUP BY u.user_id ORDER BY u.doi DESC
            ";

        $result = mysqli_query($this->conn,$sql);
        return $result;
    }

    public function user_profile_base_fetch($user_id) {

      $sql = "
            SELECT
            cbl_user.user_id AS user_id,
            cbl_user.first_name AS first_name,
            cbl_user.last_name AS last_name,
            cbl_user.phone_no AS phone_no,
            cbl_user.address AS address,
            cbl_user.area AS area,
            cbl_user.doi AS doi,
            cbl_user.user_status AS user_status,
            cbl_dev_stock.device_no AS device_no,
            cbl_dev_stock.device_mso AS device_mso,
            cbl_dev_stock.device_type AS device_type,
            cbl_dev_stock.package AS package

            FROM cbl_user_dev

            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

            WHERE cbl_user.user_id = '$user_id'";

  
      $result = mysqli_query($this->conn,$sql);
      return $result;
    }

    public function user_profile_ledger_fetch($user_id) {

      $sql = "
                    SELECT * FROM cbl_user_dev

                    RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                    LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
                    LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

                    WHERE cbl_ledger.user_id = '$user_id'
                    ORDER BY renew_date DESC
                ";
      $result = mysqli_query($this->conn,$sql);
      return $result;
    }

    public function user_profile_select_device_fetch($user_id) {

          $sql = "
                    SELECT
                    cbl_user_dev.user_id AS user_id,
                    cbl_dev_stock.dev_id AS dev_id,
                    cbl_dev_stock.device_no AS device_no,
                    cbl_dev_stock.device_mso AS device_mso,
                    cbl_dev_stock.device_type AS device_type,
                    MAX(cbl_ledger.renew_date) AS renew_date,
                    MAX(cbl_ledger.expiry_date) AS expiry_date

                    FROM cbl_user_dev

                    RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                    LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
                    LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

                    WHERE cbl_user_dev.user_id = '$user_id'
                    GROUP BY cbl_dev_stock.dev_id
                    ";
      $result = mysqli_query($this->conn,$sql);
      return $result;
    }

    public function user_profile_renewal_fetch($user_id,$dev_id) {

            $sql = "
                    SELECT
                    cbl_user_dev.user_id AS user_id,
                    cbl_user.first_name AS first_name,
                    cbl_user.last_name AS last_name,
                    cbl_user.phone_no AS phone_no,
                    cbl_user.address AS address,
                    cbl_user.area AS area,
                    cbl_dev_stock.dev_id AS dev_id,
                    cbl_dev_stock.device_no AS device_no,
                    cbl_dev_stock.package AS package,
                    cbl_dev_stock.device_mso AS device_mso,
                    cbl_dev_stock.device_type AS device_type
                    
                    FROM cbl_user_dev

                    RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                    LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                    
                    WHERE cbl_user_dev.dev_id = '$dev_id'
                    ";

          $result = mysqli_query($this->conn,$sql);
          return $result;
    }

    public function user_profile_renewal() {

      if(isset($_POST['submit'])) {

      $dev_id = $_POST['dev_id'];
      $user_id = $_POST['user_id'];
      $invoice_no = $_POST['invoice_no'];
      $package = $_POST['package'];
      $renew_date = $_POST['renew_date'];
      $renew_term = $_POST['renew_term'];
      

      $renew_term_month = $renew_term." "."months";
      $due_amount = $package * $renew_term;


    // Preparing Expiry date and Month to insert into the database.
      $format_renew = date_create($renew_date);
      $format_expiry = date_add($format_renew,date_interval_create_from_date_string($renew_term_month));

    // Finalized after conversion.
      $renew_month = date('F',strtotime($renew_date));
      $expiry_date = date_format($format_expiry,'Y-m-d');
      $expiry_month = date('F',strtotime($expiry_date));

    // Query.
      $sql = "  INSERT INTO cbl_ledger (user_id,dev_id,renew_date,renew_month,expiry_month,expiry_date,renew_term,renew_term_month,invoice_no,due_amount) VALUES ('$user_id','$dev_id','$renew_date','$renew_month','$expiry_month','$expiry_date','$renew_term','$renew_term_month','$invoice_no','$due_amount')";

      if(mysqli_query($this->conn,$sql)){
        
        $msg = 'Activation Successful.';
            header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

      } else {
        
        $msg = 'Database Error.';
            header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

      }
    }
  }

  public function user_profile_payment_fetch($ledger_id) {

    $sql = "
              SELECT
              cbl_dev_stock.device_no AS device_no,
              cbl_dev_stock.device_mso AS device_mso,
              cbl_ledger.renew_date AS renew_date,
              cbl_ledger.expiry_date AS expiry_date,
              cbl_ledger.renew_month AS renew_month,
              cbl_ledger.invoice_no AS invoice_no,
              cbl_ledger.due_amount AS due_amount,
              cbl_ledger.pay_balance AS pay_balance,
              cbl_ledger.ledger_id AS ledger_id,
              cbl_ledger.user_id AS user_id

              FROM cbl_user_dev

              RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
              LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
              LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

              WHERE cbl_ledger.ledger_id = '$ledger_id'
            ";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }

  public function user_profile_payment() {

    if(isset($_POST['submit'])) {

      $user_id = $_POST['user_id'];
      $ledger_id = $_POST['ledger_id'];
      $due_amount = $_POST['due_amount'];
      $pay_amount = $_POST['pay_amount'];
      $pay_date = $_POST['pay_date'];
      $due_invoice = $_POST['due_invoice'];
      $pay_month = date('F',strtotime($pay_date));

      $sql = "
                UPDATE cbl_ledger SET
                pay_amount = '$pay_amount',
                pay_date = '$pay_date',
                pay_month = '$pay_month',
                ledger_status = 'Paid',
                pay_balance = CASE
                                WHEN '$pay_amount' < '$due_amount' THEN '$pay_amount' - '$due_amount'
                                WHEN '$pay_amount' > '$due_amount' THEN '$pay_amount' - '$due_amount'
                                WHEN '$pay_amount' = '$due_amount' THEN '$pay_amount' - '$due_amount'
                              END,
                pay_status =  CASE
                                WHEN '$pay_amount' < '$due_amount' THEN 'Balance'
                                WHEN '$pay_amount' > '$due_amount' THEN 'Advance'
                                WHEN '$pay_amount' = '$due_amount' THEN 'Clear'
                              END

                WHERE ledger_id = '$ledger_id'
              ";

      if(mysqli_query($this->conn,$sql)){
      
        $msg = 'Payment Added Successfully.';
        header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

      } else {
      
        $msg = 'Database Error.';
        header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

      }
    }
  }

  public function user_profile_device_fetch($user_id) {

        $sql = "
                SELECT * FROM cbl_user_dev
                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                WHERE cbl_user_dev.user_id = '$user_id'
                ";

      $result = mysqli_query($this->conn,$sql);
      return $result;
  }

  public function user_device_map() {

      if(isset($_POST['submit'])) {

          $user_id = $_POST['user_id'];
          $device_no = $_POST['device_no'];

        // Extracting dev_id by device_no.
          $result = mysqli_query($this->conn,"SELECT * FROM cbl_dev_stock WHERE device_no = '$device_no'");
          $data = mysqli_fetch_assoc($result);

          if(!empty($data['dev_id'])){

          $dev_id = $data['dev_id'];

          $sql = "
                    INSERT INTO cbl_user_dev
                    (user_id,dev_id)
                    VALUES
                    ('$user_id','$dev_id')
                  ";
          $result = mysqli_query($this->conn,$sql);

          $msg = 'Device Mapped Successfully.';
          header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

        } else {

          $msg = 'Please insert valid device number!';
          header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);
            
        }
      }
    }

  public function user_profile_device_list_fetch() {

      $sql = "
              SELECT
              cbl_dev_stock.dev_id AS dev_id,
              cbl_dev_stock.device_no AS device_no,
              cbl_dev_stock.device_mso AS device_mso,
              cbl_dev_stock.device_type AS device_type,
              cbl_dev_stock.package AS package,
              cbl_user.user_id AS user_id,
              cbl_user.first_name AS first_name,
              cbl_user.last_name AS last_name,
              cbl_user_dev.assign_id AS assign_id

              FROM cbl_user_dev
              LEFT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
              RIGHT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
              ORDER BY cbl_user.user_id ASC
              ";
      $result = mysqli_query($this->conn,$sql);
      return $result;
  }

  public function device_entry() {

      if(isset($_POST['submit'])) {

      $user_id = $_POST['user_id'];
      $device_no = mysqli_real_escape_string($this->conn,$_POST['device_no']);
      $device_mso = mysqli_real_escape_string($this->conn,$_POST['device_mso']);
      $device_type = mysqli_real_escape_string($this->conn,$_POST['device_type']);
      $package = mysqli_real_escape_string($this->conn,$_POST['package']);

      $sql = "  INSERT INTO cbl_dev_stock
            (device_no,device_mso,device_type,package)
            VALUES
            ('$device_no','$device_mso','$device_type','$package')";

      if(mysqli_query($this->conn,$sql)){

        $msg = 'Device Entry Successfull.';
        header('Location: device_entry.php?msg='.$msg);

      } else {

        $msg = 'Database Error.';
        header('Location: device_entry.php?msg='.$msg);

      }
    }
  }

  public function device_delete($dev_id) {

    $sql = "DELETE FROM cbl_dev_stock WHERE dev_id ='" . $dev_id . "'";

    if(mysqli_query($this->conn,$sql)){

        $msg = 'Device Deleted Successfully.';
        header('Location: device_entry.php?msg='.$msg);

      } else {

        $msg = 'Database Error.';
        header('Location: device_entry.php?msg='.$msg);
      }
  }

  public function device_edit_fetch($dev_id) {

    $sql = "SELECT * FROM cbl_dev_stock WHERE dev_id = '$dev_id'";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }

  public function device_edit() {

    if(isset($_POST['submit'])) {

      $dev_id = $_POST['dev_id'];
      $device_no = mysqli_real_escape_string($this->conn,$_POST['device_no']);
      $device_mso = mysqli_real_escape_string($this->conn,$_POST['device_mso']);
      $device_type = mysqli_real_escape_string($this->conn,$_POST['device_type']);
      $package = mysqli_real_escape_string($this->conn,$_POST['package']);

      $sql = "  UPDATE cbl_dev_stock
                SET
                device_no = '$device_no',
                device_mso = '$device_mso',
                device_type = '$device_type',
                package = '$package'

                WHERE dev_id = '$dev_id'
              ";

      if(mysqli_query($this->conn,$sql)){
        
        $msg = 'Device Updation Successful.';
        header('Location: device_entry.php?msg='.$msg);

      } else {
        
        $msg = 'Database Error.';
        header('Location: device_entry.php?msg='.$msg);

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