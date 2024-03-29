<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    require_once 'config/init.php';
    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

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
              WHERE ledger_id = '" .$_GET['ledger_id']. "'
            ";


    $row = $organ->query($sql)->fetch_assoc();

    // GST Declaration on Plan Rate and conversion to Numbers.
    $gst = intval(18/100 * $row["package"]);
    $package = intval($row['package']);
    $duration = intval($row['renew_term']);
    $discount = intval($row['pay_discount']);

    $gst_duration = $gst * $duration;
    $sub_total = ($package - $gst) * $duration;
    $grand_total = $sub_total + $gst_duration;

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?php echo $row['first_name']; ?>'s Receipt</h1>
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
            <div class="ribbon-wrapper ribbon-lg">
              <div class="ribbon bg-success text-lg">
                Paid
              </div>
            </div>
            <img src="assets/images/fb_logo.png" alt="FB_Logo" class="img-thumbnail">
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
              Connections: <?php echo 2; ?>
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Invoice #<?php echo $row['invoice_no']; ?></b><br>
            <br>
            <b>Order ID:</b> <?php echo $row['ledger_id'] . rand(0,999); ?><br>
            <b>Payment Due:</b> <?php echo date('jS M Y',strtotime($row['renew_date'])); ?><br>
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
                <th>Device</th>
                <th>Service Period</th>
                <th>Plan Rate</th>
                <th>Duration</th>
                <th>Subtotal</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td><?php echo $row['device_no'].' '.$row['device_mso']; ?></td>
                <td><?php echo date('j M Y',strtotime($row['renew_date'])); ?> - <?php echo date('j M Y',strtotime($row['expiry_date'])); ?></td>
                <td>Rs.<?php echo $package; ?></td>
                <td><?php echo $row['renew_term_month']; ?></td>
                <td>Rs.<?php echo $sub_total; ?></td>
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
            <img src="assets/images/paytm.png" alt="Paytm">
            <img src="assets/images/phonepe.png" alt="PhonePe">
            <img src="assets/images/gpay.png" alt="GooglePay">
            <img src="assets/images/upi.png" alt="UPI">

            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              * Payment should be made on the due date.
            </p>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <p class="lead">Paid On: <?php echo date('jS M Y',strtotime($row['pay_date'])); ?></p>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>Rs.<?php echo $sub_total; ?></td>
                </tr>
                <tr>
                  <th>CGST + SGST (18%)</th>
                  <td>Rs.<?php echo $gst_duration; ?></td>
                </tr>
                <tr>
                  <th>Grand Total:</th>
                  <td>Rs.<?php echo $grand_total; ?></td>
                </tr>
                <tr>
                  <th>Discount:</th>
                  <td>Rs.<?php echo $discount; ?></td>
                </tr>
                <tr>
                  <th>Paid Total:</th>
                  <td>Rs.<?php echo $grand_total; ?></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row no-print">
          <div class="col-12">
            <input type="button" value="Print" class="btn btn-success float-right" onclick="printPage();"></input>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

  <?php require_once 'includes/footer.php'; ?>

<script language="javascript">
    function printPage() {
        window.print();
    }
</script>