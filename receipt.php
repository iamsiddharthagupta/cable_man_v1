<?php

if(isset($_POST["generate_pdf"])){
			
		$output = '';
		include '../common/connection.php';

		require_once('../common/tcpdf/tcpdf.php');
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$obj_pdf->SetTitle("Payment Receipt");
		$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$obj_pdf->SetDefaultMonospacedFont('helvetica');  
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, 10);
		$obj_pdf->SetFont('helvetica', '', 11);
		$obj_pdf->AddPage();
		$content = '';

		$ledger_id = $_POST['ledger_id'];
		$query = "
					SELECT * FROM cbl_ledger
					LEFT JOIN cbl_user ON cbl_user.user_id = cbl_ledger.user_id
					RIGHT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_ledger.dev_id

					WHERE ledger_id = '$ledger_id'
				";
		$result = mysqli_query($conn, $query);

		foreach ($result as $key => $data) {
		
		$content .= '
		<h4 align="center">Thank you...'.$data["first_name"].' '.$data["last_name"].'</h4>
			<hr>
				<table border="1" cellspacing="0" cellpadding="3">

					<tr>
						<th>Receipt #</th>
						<th>Name</th>
						<th>Package</th>
						<th>Plan Activated</th>
						<th>Plan Expiry</th>
					</tr>
		';

		$output .= '
					<tr>
						<td>'.$data["invoice_no"].'</td>
						<td>'.$data["first_name"].' '.$data["last_name"].'</td>
						<td>INR '.$data["package"].'</td>
						<td>'.$data["renew_date"].'</td>
						<td>'.$data["expiry_date"].'</td>
					</tr>
					<tr>
						<th>Address</th>
						<td colspan="7" align="center">'.$data['address'].', '.$data['area'].'</td>
					</tr>
					<tr>
						<th>Paid Amount</th>
						<td colspan="7" align="center">INR '.$data['pay_amount'].'</td>
					</tr>
					<tr>
						<th>Payment Date</th>
						<td colspan="7" align="center">'.$data['pay_date'].'</td>
					</tr>
					<tr>
						<th>Device Details</th>
						<td colspan="7" align="center">'.$data['device_no'].' '.$data['device_mso'].'</td>
					</tr>
					<tr>
						<td colspan="7">'.'This is a Computer generated receipt hence signature not required. Team, Aalishan Cable'.'</td>
					</tr>
		';

		$content .= $output;
		$content .= '</table>';
		$obj_pdf->writeHTML($content);
		$obj_pdf->Output('receipt.pdf', 'I');
	}
}

?>