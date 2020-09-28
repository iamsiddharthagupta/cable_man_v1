<?php

  ob_start();

	require_once 'organ.php';

  $result = $user->pay_receipt($_GET['ledger_id']);

	$row = mysqli_fetch_assoc($result);

	// Invoice Part from below --------------------------------------------------------------------------------->
    // Include autoloader 
    require_once 'vendor/autoload.php';
 
    // Reference the Dompdf namespace 
    use Dompdf\Dompdf;

    $html = '

            <!DOCTYPE html>
              <html lang="en">
                <head>
                  <meta charset="utf-8">
                  
                  <title>Thank you... '.$row['first_name'].' '.$row['last_name'].'</title>
                  
                  <style type="text/css">
                    .clearfix:after {
                      content: "";
                      display: table;
                      clear: both;
                    }

                    a {
                      color: #5D6975;
                      text-decoration: underline;
                    }

                    body {
                      position: relative;
                      width: 21cm;  
                      height: 29.7cm; 
                      margin: 0 auto; 
                      color: #001028;
                      background: #FFFFFF; 
                      font-size: 12px; 
                      font-family: Arial;
                    }

                    header {
                      padding: 10px 0;
                      margin-bottom: 30px;
                    }


                    h1 {
                      border-top: 1px solid  #5D6975;
                      border-bottom: 1px solid  #5D6975;
                      color: #5D6975;
                      font-size: 2.4em;
                      line-height: 1.4em;
                      font-weight: normal;
                      text-align: center;
                      margin: 0 0 20px 0;
                    }

                    #customer {
                      float: left;
                    }

                    #customer span {
                      color: #5D6975;
                      text-align: right;
                      width: 52px;
                      margin-right: 10px;
                      display: inline-block;
                      font-size: 0.8em;
                    }

                    #company {
                      float: right;
                    }

                    #customer div,
                    #company div {
                      white-space: nowrap;        
                    }

                    table {
                      width: 100%;
                      border-collapse: collapse;
                      border-spacing: 0;
                      margin-bottom: 20px;
                    }

                    table tr:nth-child(2n-1) td {
                      background: #F5F5F5;
                    }

                    table th,
                    table td {
                      text-align: center;
                    }

                    table th {
                      padding: 5px 20px;
                      color: #5D6975;
                      border-bottom: 1px solid #C1CED9;
                      white-space: nowrap;        
                      font-weight: normal;
                    }

                    table .service,
                    table .desc {
                      text-align: left;
                    }

                    table td {
                      padding: 20px;
                      text-align: right;
                    }

                    table td.service,
                    table td.desc {
                      vertical-align: top;
                    }

                    table td.unit,
                    table td.qty,
                    table td.total {
                      font-size: 1.2em;
                    }

                    table td.grand {
                      border-top: 1px solid #5D6975;;
                    }

                    #notices .notice {
                      color: #5D6975;
                      font-size: 1.2em;
                    }

                    footer {
                      color: #5D6975;
                      width: 100%;
                      height: 30px;
                      position: absolute;
                      bottom: 0;
                      border-top: 1px solid #C1CED9;
                      padding: 8px 0;
                      text-align: center;
                    }
                  </style>
                </head>
                <body>
                  <header class="clearfix">
                    <h1>RECEIPT #'.$row["invoice_no"].'</h1>
                    <div id="company" class="clearfix">
                      <div><span>Aalishan Cable TV & Internet Service</span></div>
                      <div><span>GSTIN</span> 07ALHPG0805D2ZP</span></div>
                      <div><span>20-C, Ground Floor, Krishna Nagar<br /> Safdarjung Enclave, South-West Delhi - 110029</span></div>
                      <div><span>011-26176696, +91-8285433529</span></div>
                    </div>
                    <div id="customer">
                      <div><span>NAME</span> '.$row["first_name"]." ".$row["last_name"].'</div>
                      <div><span>ADDRESS</span> '.$row["address"].", ".$row["area"].'</div>
                      <div><span>PHONE</span> '.$row["phone_no"].'</div>
                      <div><span>DUE DATE</span> '.date("jS M, Y",strtotime($row["renew_date"])).'</div>
                    </div>
                  </header>
                  <main>
                    <table>
                      <thead>
                        <tr>
                          <th class="service">PACKAGE</th>
                          <th class="desc">VALIDITY</th>
                          <th>PRICE</th>
                          <th>DURATION</th>
                          <th>TOTAL</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="service">INR '.$row['package'].'</td>
                          <td class="desc"><span>'.date("jS M y",strtotime($row["renew_date"])).'</span> - <span>'.date("jS M y",strtotime($row["expiry_date"])).'</span></td>
                          <td class="unit">INR '.$row['package'].'</td>
                          <td class="qty"> 1</td>
                          <td class="total">INR </td>
                        </tr>
                        <tr>
                          <td colspan="4">GST 18%</td>
                          <td class="total">INR </td>
                        </tr>
                        <tr>
                          <td colspan="4">GRAND TOTAL</td>
                          <td class="total">INR </td>
                        </tr>
                        <tr>
                          <td colspan="4" class="grand total">PAID AMOUNT</td>
                          <td class="grand total">INR '.$row["pay_amount"].'</td>
                        </tr>
                      </tbody>
                    </table>
                    <div id="notices">
                      <div>NOTE:</div>
                      <div class="notice">We Accept and Encourage Various Digital Payment Modes, e.g. Paytm, PhonePe, Google Pay, NEFT, etc.</div>
                    </div>
                  </main>
                  <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                  </footer>
                </body>
              </html>

            ';

    $codeHtml = utf8_encode($html);

    // Instantiate and use the dompdf class 
    $dompdf = new Dompdf();

    // Load HTML content 
    $dompdf->loadHtml($codeHtml); 
     
    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'landscape'); 
     
    // Render the HTML as PDF 
    $dompdf->render(); 
     
    // Output the generated PDF to Browser 
    $dompdf->stream("receipt", array("Attachment" => 0));

?>