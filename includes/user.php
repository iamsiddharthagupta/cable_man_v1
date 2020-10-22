<?php

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

  public function user_profile_payment() {

    if(isset($_POST['submit'])) {

      $user_id = $_POST['user_id'];
      $ledger_id = $_POST['ledger_id'];
      $due_amount = $_POST['due_amount'];
      $pay_amount = $_POST['pay_amount'];
      $pay_discount = $_POST['pay_discount'];
      $pay_date = $_POST['pay_date'];
      $due_invoice = $_POST['due_invoice'];
      $pay_month = date('F',strtotime($pay_date));

      $sql = "
                UPDATE cbl_ledger SET
                pay_amount = '$pay_amount',
                pay_discount = '$pay_discount',
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

  public function user_profile_ledger_delete($ledger_id,$user_id) {


    $sql = "DELETE FROM cbl_ledger WHERE ledger_id = '$ledger_id'";

      if(mysqli_query($this->conn,$sql)) {

        $msg = 'Entry Deleted Successfully.';
        header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

      } else {

        $msg = 'Database Error.';
        header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

      }

  }

  public function pay_receipt($ledger_id) {

    $sql = "
              SELECT

              u.user_id,
              u.first_name,
              u.last_name,
              u.address,
              u.area,
              u.phone_no,
              l.ledger_id,
              l.invoice_no,
              l.renew_date,
              l.expiry_date,
              l.pay_amount,
              l.pay_discount,
              l.renew_term,
              l.renew_term_month,
              l.pay_date,
              d.package,
              d.device_no,
              d.device_mso

              FROM cbl_ledger l
              
              LEFT JOIN cbl_user u ON u.user_id = l.user_id
              RIGHT JOIN cbl_dev_stock d ON d.dev_id = l.dev_id

              WHERE ledger_id = '$ledger_id'
            ";
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }

    public function user_profile_base_fetch($user_id) {

      $sql = "
            SELECT
            u.user_id,
            u.first_name,
            u.last_name,
            u.phone_no,
            u.address,
            u.area,
            u.doi,
            u.user_status,
            d.device_no,
            CONCAT('Rs.',d.package,' - ',d.device_mso) AS device_details,
            d.device_type,
            d.dev_id

            FROM cbl_user_dev ud

            RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
            LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

            WHERE u.user_id = '$user_id'";

  
      $result = mysqli_query($this->conn,$sql);
      return $result;
    }

    public function user_profile_ledger_fetch($user_id) {

          $sql = "
                    SELECT

                    d.dev_id,
                    d.device_no,
                    l.ledger_id,
                    l.renew_date,
                    l.expiry_date,
                    l.renew_term,
                    l.due_amount,
                    l.pay_amount,
                    l.pay_balance,
                    CASE
                      WHEN l.pay_status IS NULL THEN '-'
                      ELSE l.pay_status
                    END AS pay_status,
                    CASE
                      WHEN l.pay_date IS NULL THEN 'Unpaid'
                      ELSE DATE_FORMAT(l.pay_date, '%e %b %Y')
                    END AS pay_date,
                    l.ledger_status,
                    l.user_id

                    FROM cbl_user_dev ud

                    RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
                    LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
                    LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

                    WHERE l.user_id = '$user_id'
                    ORDER BY renew_date DESC
                ";
      $result = mysqli_query($this->conn,$sql);
      return $result;
    }

    public function user_profile_renewal_fetch($user_id, $dev_id) {

            $sql = "
                    SELECT
                    ud.user_id,
                    d.dev_id,
                    d.device_no,
                    d.package,
                    d.device_mso,
                    d.device_type,
                    CASE
                      WHEN l.renew_date AND l.expiry_date IS NULL THEN 'Unavailable'
                      ELSE CONCAT(MAX(l.renew_date), MAX(l.expiry_date))
                    END AS dates,
                    MAX(l.renew_date) AS renew_date,
                    MAX(l.expiry_date) AS expiry_date

                    FROM cbl_user_dev ud

                    LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
                    LEFT JOIN cbl_ledger l ON l.user_id = ud.user_id
                    WHERE ud.dev_id = '$dev_id' AND ud.user_id = '$user_id'
                  ";

          $result = mysqli_query($this->conn,$sql);
          return $result;
    }

  public function user_profile_payment_fetch($ledger_id) {

    $sql = "
              SELECT
              d.device_no,
              d.device_mso,
              l.renew_date,
              l.expiry_date,
              l.renew_month,
              l.invoice_no,
              l.due_amount,
              l.pay_balance,
              l.ledger_id,
              l.user_id

              FROM cbl_user_dev ud

              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

              WHERE l.ledger_id = '$ledger_id'
            ";
    $result = mysqli_query($this->conn,$sql);
    return $result;
  }

    public function user_list() {

    $sql = " SELECT
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
                WHEN u.user_status = 1 THEN 'Active'
              END AS user_status

              FROM cbl_user_dev ud

              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
              WHERE u.user_status = 1 AND ud.dev_id IS NOT NULL
              GROUP BY u.user_id
              ORDER BY u.doi DESC
          ";

        return mysqli_query($this->conn,$sql);
    }

    public function user_list_disconnect() {

    $sql = " SELECT
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
                WHEN u.user_status = 0 THEN 'Disconnected'
                WHEN ud.dev_id IS NULL THEN 'Device Unmapped'
              END AS user_status

              FROM cbl_user_dev ud

              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
              WHERE u.user_status = 0 OR ud.dev_id IS NULL
              GROUP BY u.user_id
              ORDER BY u.doi DESC
          ";

        return mysqli_query($this->conn,$sql);
    }

  public function user_list_active() {

    $sql = "
              SELECT
              u.user_id,
              u.first_name,
              u.last_name,
              u.phone_no,
              u.address,
              u.area,
              d.dev_id,
              d.device_no,
              d.device_mso,
              l.ledger_id,
              l.renew_date,
              l.expiry_date,
              CASE
                WHEN l.pay_amount = 0 THEN 'Due'
                ELSE 'Paid'
              END AS status,
              CASE
                WHEN CURDATE() = l.expiry_date THEN '(Expiring)'
              END AS ledger_status

              FROM cbl_user_dev ud

              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              RIGHT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

              WHERE u.user_status = 1 AND CURDATE() BETWEEN l.renew_date AND l.expiry_date AND l.renew_date = (SELECT MAX(l.renew_date) FROM cbl_ledger)
              GROUP BY u.user_id,ud.dev_id
              ORDER BY l.expiry_date ASC
            ";

    return mysqli_query($this->conn,$sql);
  }

  public function user_list_scheme() {

    $sql = "
              SELECT
              u.user_id,
              u.first_name,
              u.last_name,
              u.phone_no,
              u.address,
              u.area,
              d.package,
              d.device_no,
              d.device_mso,
              MAX(l.renew_date) AS renew_date,
              MAX(l.expiry_date) AS expiry_date,
              l.ledger_id,
              l.renew_term,
              SUM(l.pay_amount) AS pay_amount,
              CASE
                WHEN CURDATE() = l.expiry_date THEN '(Expiring)'
              END AS ledger_status

              FROM cbl_user_dev ud

              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              RIGHT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

              WHERE u.user_status = 1 AND CURDATE() BETWEEN l.renew_date AND l.expiry_date AND l.renew_term > 1
              GROUP BY u.user_id,ud.dev_id
              ORDER BY l.expiry_date ASC
            ";

    return mysqli_query($this->conn,$sql);
  }

  public function user_list_expired() {

    $sql = "
              SELECT
              u.user_id,
              u.first_name,
              u.last_name,
              u.phone_no,
              u.address,
              u.area,
              d.package,
              d.dev_id,
              d.device_no,
              d.device_mso,
              MAX(l.renew_date) AS renew_date,
              MAX(l.expiry_date) AS expiry_date,
              l.ledger_id

              FROM cbl_user_dev ud
              
              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              RIGHT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

              WHERE u.user_status = 1 AND l.user_id NOT IN (SELECT user_id FROM cbl_ledger WHERE expiry_date > CURDATE())

              GROUP BY u.user_id,ud.dev_id
              ORDER BY l.expiry_date ASC
            ";

    return mysqli_query($this->conn,$sql);
  }

  public function user_list_unpaid() {

    $sql = "
              SELECT
              u.user_id,
              u.first_name,
              u.last_name,
              u.address,
              u.area,
              u.phone_no,
              SUM(l.renew_term) AS months,
              SUM(l.due_amount) AS dues,
              l.user_id,
              l.ledger_id

              FROM cbl_user_dev ud
              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
              LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
              WHERE l.ledger_status = 'Renewed'
              GROUP BY l.user_id
              ORDER BY months DESC
            ";

    return mysqli_query($this->conn,$sql);
  }

  public function dashboard_expiring_list() {

    $sql = "
              SELECT
              u.first_name,
              u.last_name,
              CONCAT(u.address,', ',u.area) AS address,
              MAX(l.expiry_date) AS expiry_date,
              l.ledger_status AS status

              FROM cbl_user_dev ud

              LEFT JOIN cbl_user u ON u.user_id = ud.user_id
              LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id

              WHERE u.user_status = 1 AND l.expiry_date = CURDATE()
              GROUP BY u.user_id
              ORDER BY l.expiry_date ASC
          ";

    return mysqli_query($this->conn,$sql);

  }


  public function day_collection_summary() {

      $sql = "
              SELECT pay_date AS pay_date,
              SUM(pay_amount) AS pay_amount
              FROM cbl_ledger
              WHERE pay_amount > 0
              GROUP BY pay_date
              ORDER BY pay_date DESC
            ";

    return mysqli_query($this->conn,$sql);
  }

  public function month_collection_summary() {

      $sql = "
              SELECT MONTHNAME(pay_date) AS month,
              SUM(pay_amount) AS pay_amount
              FROM cbl_ledger
              WHERE pay_amount > 0
              GROUP BY month
              ORDER BY month ASC
            ";

    return mysqli_query($this->conn,$sql);
  }

  // Counting functions

  public function CountExpiring() {
    $sql = "SELECT COUNT(ledger_id) AS count_expiring FROM cbl_ledger WHERE expiry_date = CURDATE()";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count_expiring'];
  }

  public function todays_collection($date) {
    $sql = "
              SELECT
              CASE
                WHEN pay_amount IS NOT NULL THEN SUM(pay_amount)
                WHEN pay_amount IS NULL THEN '0'
              END AS pay_amount
              FROM cbl_ledger WHERE pay_date = '$date'
              ";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['pay_amount'];
  }

  public function CountRecentUser($curr_date) {
    $date = date_create($curr_date);
    date_sub($date,date_interval_create_from_date_string("1 Month"));
    $back_date = date_format($date,"Y-m-d");

    $sql = "SELECT COUNT(user_id) AS count_recent
              FROM cbl_user
              WHERE doi BETWEEN '$back_date' AND '$curr_date'";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count_recent'];
  }

  public function CountRecentRenew($date) {
    $sql = "SELECT COUNT(user_id) AS recent_renew FROM cbl_ledger WHERE renew_date = '$date'";
    $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['recent_renew'];
  }

  public function user_search() {

    if(isset($_POST['submit'])) {

      $search_input = $_POST['search_input'];

      $sql = "SELECT user_id FROM cbl_user WHERE (SELECT CONCAT(first_name,' ',last_name) = '$search_input' OR first_name = '$search_input')";
      
      if($result = mysqli_query($this->conn,$sql)) {

        $row = mysqli_fetch_assoc($result);
        header('Location: user_profile_ledger.php?user_id='.$row['user_id']);

      } else {

        echo 'Search Failed!';

      }
    }
  }

}