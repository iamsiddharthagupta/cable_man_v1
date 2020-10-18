<?php

	class Device extends Connection {

  public function user_device_map() {

      if(isset($_POST['submit'])) {

          $user_id = $_POST['user_id'];
          $device_no = $_POST['device_no'];

        // Extracting dev_id by device_no.
          $result = mysqli_query($this->conn,"SELECT * FROM cbl_dev_stock WHERE device_no = '$device_no'");
          $data = mysqli_fetch_assoc($result);

          if(!empty($data['dev_id'])){

          $dev_id = $data['dev_id'];

          $sql = "INSERT INTO cbl_user_dev (user_id,dev_id) VALUES ('$user_id','$dev_id')";

          $result = mysqli_query($this->conn,$sql);

          $msg = 'Device Mapped Successfully.';
          header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

        } else {

          $msg = 'Please insert valid device number!';
          header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

        }
      }
    }

  public function device_entry($user_id) {

      if(isset($_POST['submit'])) {

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
        header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

      } else {

        $msg = 'Database Error.';
        header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

      }
    }
  }

  public function device_edit($user_id) {

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
        header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

      } else {

        $msg = 'Database Error.';
        header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

      }
    }
  }

  public function device_delete($dev_id,$user_id) {

    $sql = "DELETE FROM cbl_dev_stock WHERE dev_id ='" . $dev_id . "'";

    if(mysqli_query($this->conn,$sql)){

        $msg = 'Device Deleted Successfully!';
        header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

      } else {

        $msg = 'Database Error.';
        header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);
      }
  }

  public function release_device($assign_id,$user_id) {

    $sql = "DELETE FROM cbl_user_dev WHERE assign_id ='" . $assign_id . "'";
    
    if(mysqli_query($this->conn,$sql)) {

      $msg = 'Device Released from the User!';
      header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

    } else {

      $msg = 'Database Error.';
      header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

    }
  }

  public function device_edit_fetch($dev_id) {

    $sql = "SELECT * FROM cbl_dev_stock WHERE dev_id = '$dev_id'";
    $result = mysqli_query($this->conn,$sql);
    return $result;
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

  public function user_profile_device_list_fetch() {

      $sql = "
              SELECT
              d.dev_id,
              d.device_no,
              d.device_mso,
              d.device_type,
              d.package,
              u.user_id,
              u.first_name,
              u.last_name,
              ud.assign_id

              FROM cbl_user_dev ud
              LEFT JOIN cbl_user u ON u.user_id = ud.user_id
              RIGHT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
              ORDER BY u.user_id ASC
              ";
      $result = mysqli_query($this->conn,$sql);
      return $result;
  }

    public function user_profile_select_device_fetch($user_id) {

          $sql = "
                    SELECT
                    ud.user_id,
                    d.dev_id,
                    d.device_no,
                    d.device_mso,
                    d.device_type,
                    MAX(l.renew_date) AS renew_date,
                    MAX(l.expiry_date) AS expiry_date

                    FROM cbl_user_dev ud

                    LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
                    LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

                    WHERE ud.user_id = '$user_id'
                    ";
      $result = mysqli_query($this->conn,$sql);
      return $result;
    }

  public function device_summary() {
    $sql = "
              SELECT
              COUNT(DISTINCT l.dev_id) AS devices,
              d.device_mso AS device_mso

              FROM cbl_ledger l
              LEFT JOIN cbl_user u ON u.user_id = l.user_id
              LEFT JOIN cbl_dev_stock d ON d.dev_id = l.dev_id
              WHERE CURDATE() BETWEEN l.renew_date AND l.expiry_date AND u.user_status = 1
              GROUP BY d.device_mso
              
            ";

    $result = mysqli_query($this->conn,$sql);
    return $result;
  }

}