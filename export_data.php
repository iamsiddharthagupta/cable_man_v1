<style type="text/css">
  table, th, td {
    border:1px solid black;
    border-collapse:collapse;
    text-align:center;
  } 
</style>

<?php  

require_once 'connection.php';

$output = '';

if(isset($_POST["export"])) {
 $query = "
          SELECT * FROM cbl_user_dev
          RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
          LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
          ";
 $result = mysqli_query($conn, $query);
 if(mysqli_num_rows($result) > 0) {
  $output .= '<table>
      <caption>User Data</caption>
      <tr>
        <th>Device ID</th>
        <th>MSO</th>
        <th>Device Type</th>
        <th>Name</th>
        <th>Contact No</th>
        <th>Address</th>
        <th>Date of Installation</th>
      </tr>';
    while ($data = mysqli_fetch_array($result)) {
     $output .= '
      <tr>  
        <td>'.$data["device_no"].'</td>
        <td>'.$data["device_mso"].'</td>
        <td>'.$data["device_type"].'</td>
        <td>'.$data["first_name"]." ".$data['last_name'].'</td>
        <td>'.$data["phone_no"].'</td>
        <td>'.$data["address"].", ".$data['area'].'</td>
        <td>'.$data["doi"].'</td>
      </tr>
     ';
    } $output .= '</table>';
      header('Content-Type: application/xls');
      header('Content-Disposition: attachment; filename=user_data.xls');
      echo $output;
     }
  }

?>