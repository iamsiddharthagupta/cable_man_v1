<?php

  session_start();

  if(isset($_SESSION['user_level'])){
    $curr_user = ucwords($_SESSION['curr_user']);
    if($_SESSION['user_level'] != 1){
      header('Location: agent_panel.php');
    }
  } else {
    header('Location: index.php');
  }

	require_once 'organ.php';

  $result = $user->pay_receipt($_GET['ledger_id']);
	$row = mysqli_fetch_assoc($result);

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Generated Receipt</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Receipt</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> Aalishan Cable TV and Internet Service
              <small class="float-right">Date: <?php echo date('jS M Y'); ?></small>
            </h4>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
              <strong>Aalishan Cable TV and Internet Service</strong><br>
              <mark>GSTIN 07ALHPG0805D2ZP</mark><br>
              20-C, Ground Floor, Krishna Nagar<br>
              Safdarjung Enclave, South-West Delhi-29<br>
              Phone: 011-26176696, 08285433529
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            To
            <address>
              <strong><?php echo $row['first_name'].' '.$row['last_name']; ?></strong><br>
              <?php echo $row['address']; ?><br>
              <?php echo $row['area']; ?><br>
              Phone: <?php echo $row['phone_no']; ?><br>
              Email: <?php echo $row['address']; ?>
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Invoice #<?php echo $row['invoice_no']; ?></b><br>
            <br>
            <b>Order ID:</b> <?php echo $row['ledger_id'] . rand(0,999); ?><br>
            <b>Payment Due:</b> 2/22/2014<br>
            <b>Account:</b> <?php echo $row['user_id']; ?>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Qty</th>
                <th>Product</th>
                <th>Serial #</th>
                <th>Description</th>
                <th>Subtotal</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>1</td>
                <td>Call of Duty</td>
                <td>455-981-221</td>
                <td>El snort testosterone trophy driving gloves handsome</td>
                <td>$64.50</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Monsters DVD</td>
                <td>735-845-642</td>
                <td>Terry Richardson helvetica tousled street art master</td>
                <td>$10.70</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Grown Ups Blue Ray</td>
                <td>422-568-642</td>
                <td>Tousled lomo letterpress</td>
                <td>$25.99</td>
              </tr>
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-6">
            <p class="lead">Accepted Payment Methods:</p>
            <img src="assets/paytm.png" alt="Paytm">
            <img src="assets/phonepe.png" alt="PhonePe">
            <img src="assets/gpay.png" alt="GooglePay">
            <img src="assets/upi.png" alt="UPI">

            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              * Payment should be made on the due date.
            </p>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <p class="lead">Amount Due 2/22/2014</p>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>$250.30</td>
                </tr>
                <tr>
                  <th>Tax (9.3%)</th>
                  <td>$10.34</td>
                </tr>
                <tr>
                  <th>Shipping:</th>
                  <td>$5.80</td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td>$265.24</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <a href="invoice-print.html" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>
          </div>
        </div>
      </div>
      <!-- /.invoice -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->


<?php require_once 'assets/footer.php'; ?>