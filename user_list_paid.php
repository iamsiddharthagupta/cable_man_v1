<?php

  session_start();

  if(isset($_SESSION['user_level'])) {
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1) {
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }
  
  require_once 'connection.php';
  require_once 'organ.php';
?>

  <div class="container-fluid p-3">

    <form method="GET" action="user_list_paid.php">
      <div class="form-row justify-content-center">
        <div class="form-group col-md-6">
          <input type="text" name="search" class="form-control" placeholder="Search by Bill Number">
        </div>
        <div class="form-group">
          <button type="submit" value="submit" class="btn btn-primary">Search</button>
        </div>
      </div>
    </form>


  <div class="card-body table-responsive p-0" style="height: 500px;">
    
    <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
          <thead class="thead-light">
            <tr>
              <th>Action</th>
              <th>Name</th>
              <th>Device</th>
              <th>Duration</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Rate</th>
            </tr>
          </thead>

  <?php

        if(isset($_GET['search'])) {

          $search = $_GET['search'];

          $sql = "SELECT * FROM cbl_ledger WHERE invoice_no LIKE '%$search%'";
          
          $result = mysqli_query($conn,$sql);

          if (mysqli_num_rows($result) < 1) {
              
              echo "<tr><td colspan='5'>No Records Found.</td><tr>";
          
          } else {

            foreach ($result as $key => $row) : ?>
              

            <tbody id="myTable">
                
                <tr>

                  

                </tr>

            </tbody>

              
  <?php
  
    endforeach;

    }
  }
  
  ?>

    </table>
  </div>
</div>

<?php require_once 'assets/footer.php'; ?>