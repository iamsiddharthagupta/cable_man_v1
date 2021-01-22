<?php

	class Update extends Connection {

	    public function user_profile_update() {

	      if(isset($_POST['submit'])) {

	        $first_name = mysqli_real_escape_string($this->conn,$_POST['first_name']);
	        $last_name = mysqli_real_escape_string($this->conn,$_POST['last_name']);
	        $phone_no = mysqli_real_escape_string($this->conn,$_POST['phone_no']);
	        $area = mysqli_real_escape_string($this->conn,$_POST['area']);
	        $address = mysqli_real_escape_string($this->conn,$_POST['address']);
	        $user_status = mysqli_real_escape_string($this->conn,$_POST['user_status']);
	        $user_id = $_POST['user_id'];

	          $sql = "UPDATE cbl_user SET
	          first_name = '$first_name',
	          last_name = '$last_name',
	          phone_no = '$phone_no',
	          address = '$address',
	          area = '$area',
	          user_status = '$user_status'

	          WHERE user_id = '$user_id'";

	          if(mysqli_query($this->conn,$sql)){

	              $msg = 'Profile Updation Successful.';
	              header('Location: user_profile_update.php?user_id='.$user_id.'&msg='.$msg);

	              } else {

	              $msg = 'Database Error.';
	              header('Location: user_profile_update.php?user_id='.$user_id.'&msg='.$msg);
	          }
	        }
	      }

		public function admin_change_pass($curr_user) {

		    if(isset($_POST['submit'])) {

			    $current_pass = $_POST['current_pass'];
			    $new_pass = $_POST['new_pass'];
			    $confirm_pass = $_POST['confirm_pass'];
			// Hashing Passkeys
			    $current_pass = md5($current_pass);
			    $new_pass = md5($new_pass);
			    $confirm_pass = md5($confirm_pass);
			// Fetching current password from database to validate password input.
			    $sql = "SELECT password FROM tbl_auth WHERE full_name = '$curr_user'";
			    $result = mysqli_query($this->conn,$sql);
			    $curr_valid = mysqli_fetch_assoc($result);
				// Logic
			      if($current_pass == $curr_valid['password']) {

			      if($new_pass == $confirm_pass){
			          $sql = "UPDATE tbl_auth SET password = '$confirm_pass' WHERE full_name = '$curr_user'";
			          $result = mysqli_query($this->conn,$sql);
			          
			          $msg = 'Congrats you password has been changed. <a href="logout.php">Logout</a> and Login again';
			          header('Location: admin_change_pass.php?msg='.$msg);
		      
			      } else {
			        
			        $msg = 'Your new and confirm password does not match.';
			        header('Location: admin_change_pass.php?msg='.$msg);
		      }

		    } else {
		      
		      $msg = 'You current password is empty or invalid.';
		      header('Location: admin_change_pass.php?msg='.$msg);

		  }
		}
	}

		public function update_device() {

			if(isset($_POST['submit'])) {

				$device_id = intval($_POST['device_id']);
				$device_no = $this->conn->real_escape_string($_POST['device_no']);
				$device_type = $this->conn->real_escape_string($_POST['device_type']);

				$sql = "  
						UPDATE tbl_device_stack SET
				        device_no = '$device_no',
				        device_type = '$device_type'
				        WHERE device_id = '$device_id'
				      ";

					if($this->conn->query($sql)) {

						$msg = 'Device updated successfully.';
						$code = 'success';
						header('Location: manage_device_list.php?msg='.$msg.'&code='.$code);

					} else {

						$msg = 'Database error.';
						$code = 'error';
						header('Location: manage_device_list.php?msg='.$msg.'&code='.$code);

					}
			}
		}

	}