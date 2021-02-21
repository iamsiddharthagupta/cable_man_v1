<?php

	class Create extends Connection {

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

	        $sql = "  INSERT INTO cbl_ledger (user_id,dev_id,renew_date,renew_month,expiry_month,expiry_date,renew_term,renew_term_month,invoice_no,due_amount) VALUES ('$user_id','$dev_id','$renew_date','$renew_month','$expiry_month','$expiry_date','$renew_term','$renew_term_month','$invoice_no','$due_amount')";

	        if(mysqli_query($this->conn,$sql)) {
	          
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

		public function admin_role_assign() {

		  if(isset($_POST['submit'])){

		    $username = $_POST['username'];
		    $password = $_POST['password'];
		    $full_name = $_POST['full_name'];
		    $contact_no = $_POST['contact_no'];
		    $user_level = $_POST['user_level'];
		    $password = md5($password);

		    if(!empty($username) && !empty($password) && !empty($contact_no) && !empty($full_name) && !empty($user_level)){

		      $sql = "INSERT INTO tbl_auth (username,password,full_name,contact_no,user_level) VALUES ('$username','$password','$full_name','$contact_no','$user_level')";
		      
		      if(mysqli_query($this->conn,$sql)) {
		        
		        $msg = 'User Created Successfully!';
		        header('Location: admin_role_assign.php?msg='.$msg);
		      
		      } else {
		        
		        $msg = 'Database Error.';
		        header('Location: admin_role_assign.php?msg='.$msg);
		      
		      }

		    } else {
		      
		      $msg = 'Please enter details';
		      header('Location: admin_role_assign.php?msg='.$msg);
		    
		    }
		  }
		}

	}