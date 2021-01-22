<?php

	class Create extends Connection {

      	public function user_profile_add() {

	        if(isset($_POST['submit'])) {

				$first_name = $this->conn->real_escape_string($_POST['first_name']);
				$last_name = $this->conn->real_escape_string($_POST['last_name']);
				$phone_no = $this->conn->real_escape_string($_POST['phone_no']);
				$install_date = $this->conn->real_escape_string($_POST['install_date']);
				$address = $this->conn->real_escape_string($_POST['address']);
				$area_id = intval($_POST['area_id']);

	          if(!empty($first_name) && !empty($phone_no) && !empty($address) && !empty($area_id)) {

	          $sql = "INSERT INTO tbl_customer (customer_status, first_name, last_name, phone_no, install_date, area_id, address)
	                    VALUES (1, '$first_name', '$last_name', '$phone_no', '$install_date', '$area_id', '$address')";

	          if($this->conn->query($sql)){
	           
	            header('Location: profile_device_map.php?user_id='.$this->conn->insert_id);

	          } else {

		        $msg = 'Database Error.';
		        $code = 'error';
		        header('Location: profile_add.php?msg='.$msg.'&code='.$code);
	          
	          }

	        } else {

		        $msg = 'Please fill details.';
		        $code = 'warning';
		        header('Location: profile_add.php?msg='.$msg.'&code='.$code);

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

		public function create_staff() {

			if(isset($_POST['submit'])) {

				$username = $_POST['username'];
				$password = md5($_POST['password']);
				$first_name = $_POST['first_name'];
				$last_name = $_POST['last_name'];
				$phone_no = $_POST['phone_no'];
				$staff_position = $_POST['staff_position'];
				$branch_id = $_POST['branch_id'];

				if(!empty($username) && !empty($password) && !empty($first_name) && !empty($last_name) && !empty($phone_no) && !empty($staff_position) && !empty($branch_id)) {

					$sql = "INSERT INTO tbl_staff (username, password, first_name, last_name, phone_no, staff_position, branch_id) VALUES ('$username', '$password', '$first_name', '$last_name', '$phone_no', '$staff_position', '$branch_id')";

					if($this->conn->query($sql)) {

						$msg = 'Staff added successfully.';
						$code = 'success';
						header('Location: manage_staff.php?msg='.$msg.'&code='.$code);

					} else {

						$msg = 'Database error.';
						$code = 'error';
						header('Location: manage_staff.php?msg='.$msg.'&code='.$code);

					}

				} else {

					$msg = 'Please fill details.';
					$code = 'warning';
					header('Location: manage_staff.php?msg='.$msg.'&code='.$code);

				}

			}

		}

		public function create_area() {

			if(isset($_POST['submit'])) {

				$area_name = $_POST['area_name'];
				$area_district = $_POST['area_district'];
				$area_city = $_POST['area_city'];
				$area_state = $_POST['area_state'];
				$area_pin = $_POST['area_pin'];
				$area_country = $_POST['area_country'];


				if(!empty($area_name) && !empty($area_district) && !empty($area_city) && !empty($area_state) && !empty($area_pin) && !empty($area_country)) {

					$sql = "INSERT INTO tbl_area (area_name, area_district, area_city, area_state, area_pin, area_country) VALUES ('$area_name', '$area_district', '$area_city', '$area_state', '$area_pin', '$area_country')";

						if($this->conn->query($sql)) {

							$msg = 'Area added successfully.';
							$code = 'success';
							header('Location: manage_area.php?msg='.$msg.'&code='.$code);

						} else {

							$msg = 'Database error.';
							$code = 'error';
							header('Location: manage_area.php?msg='.$msg.'&code='.$code);

						}

				} else {

					$msg = 'Please fill details.';
					$code = 'warning';
					header('Location: manage_area.php?msg='.$msg.'&code='.$code);

				}

			}

		}


		public function create_mso() {

			if(isset($_POST['submit'])) {

				$mso_name = $_POST['mso_name'];
				$mso_price = $_POST['mso_price'];

				if(!empty($mso_name) && !empty($mso_price)) {

					if($this->conn->query("INSERT INTO tbl_mso (mso_name, mso_price) VALUES ('$mso_name', '$mso_price')")) {

						$msg = 'MSO added successfully.';
						$code = 'success';
						header('Location: manage_mso.php?msg='.$msg.'&code='.$code);

					} else {

						$msg = 'Database error.';
						$code = 'error';
						header('Location: manage_mso.php?msg='.$msg.'&code='.$code);

					}

				} else {

						$msg = 'Please fill details.';
						$code = 'warning';
						header('Location: manage_mso.php?msg='.$msg.'&code='.$code);

				}

			}

		}

		public function create_package() {

			if(isset($_POST['submit'])) {

				$mso_id = $_POST['mso_id'];
				$pack_name = $_POST['pack_name'];
				$pack_price = $_POST['pack_price'];
				$pack_type = $_POST['pack_type'];
				$pack_duration = $_POST['pack_duration'];

				if(!empty($mso_id) && !empty($pack_name) && !empty($pack_price) && !empty($pack_type) && !empty($pack_duration)) {

					$sql = "INSERT INTO tbl_package (mso_id, pack_name, pack_price, pack_type, pack_duration) VALUES ('$mso_id', '$pack_name', '$pack_price', '$pack_type', '$pack_duration')";

					if($this->conn->query($sql)) {

						$msg = 'Package added successfully.';
						$code = 'success';
						header('Location: manage_package.php?msg='.$msg.'&code='.$code);

					} else {

						$msg = 'Database error.';
						$code = 'error';
						header('Location: manage_package.php?msg='.$msg.'&code='.$code);

					}

				} else {

					$msg = 'Please fill details.';
					$code = 'warning';
					header('Location: manage_package.php?msg='.$msg.'&code='.$code);

				}

			}

		}

		public function create_branch() {

			if(isset($_POST['submit'])) {

				$branch_name = $_POST['branch_name'];
				$branch_gst = $_POST['branch_gst'];
				$branch_landline = $_POST['branch_landline'];
				$branch_mobile = $_POST['branch_mobile'];
				$branch_address = $_POST['branch_address'];
				$area_id = $_POST['area_id'];

				if(!empty($branch_name) && !empty($branch_gst) && !empty($branch_landline) && !empty($branch_mobile) && !empty($branch_address) && !empty($area_id)) {

					$sql = "INSERT INTO tbl_branch (branch_name, branch_gst, branch_landline, branch_mobile, branch_address, area_id) VALUES ('$branch_name', '$branch_gst', '$branch_landline', '$branch_mobile', '$branch_address', '$area_id')";

					if($this->conn->query($sql)) {

						$msg = 'Branch added successfully.';
						$code = 'success';
						header('Location: manage_branch.php?msg='.$msg.'&code='.$code);

					} else {

						$msg = 'Database error.';
						$code = 'error';
						header('Location: manage_branch.php?msg='.$msg.'&code='.$code);

					}

				} else {

					$msg = 'Please fill details.';
					$code = 'warning';
					header('Location: manage_branch.php?msg='.$msg.'&code='.$code);

				}

			}

		}

		public function create_device() {

			if(isset($_POST['submit'])) {

				$device_no = $this->conn->real_escape_string($_POST['device_no']);
				$device_type = $this->conn->real_escape_string($_POST['device_type']);

				if(!empty($device_no) && !empty($device_type)) {

					$check = $this->conn->query("SELECT device_no FROM tbl_device_stack WHERE device_no = '$device_no'");

					if($check->num_rows > 0) {

						$msg = 'Device already exist.';
						$code = 'info';
						header('Location: manage_device_add.php?msg='.$msg.'&code='.$code);

					} else {

						$sql = "INSERT IGNORE INTO tbl_device_stack (device_no, device_type) VALUES ('$device_no','$device_type')";

						if(mysqli_query($this->conn,$sql)){

							$msg = 'Device added successfully.';
							$code = 'success';
							header('Location: manage_device_list.php?msg='.$msg.'&code='.$code);

						} else {

							$msg = 'Database error.';
							$code = 'error';
							header('Location: manage_device_list.php?msg='.$msg.'&code='.$code);

						}

					}

				} else {

					$msg = 'Please fill details.';
					$code = 'warning';
					header('Location: manage_device_add.php?msg='.$msg.'&code='.$code);

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