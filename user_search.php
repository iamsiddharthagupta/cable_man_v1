<?php
include "../common/connection.php";
if (isset($_GET['term'])) {
     
   $query = "SELECT * FROM cbl_user WHERE first_name LIKE '{$_GET['term']}%' OR last_name LIKE '{$_GET['term']}%' LIMIT 5";
    $result = mysqli_query($conn, $query);
 
    if (mysqli_num_rows($result) > 0) {
     while ($user = mysqli_fetch_array($result)) {
      $res[] = $user['first_name']." ".$user['last_name'];
     }
    } else {
      $res = array();
    }
    //return json res
    echo json_encode($res);
}
?>