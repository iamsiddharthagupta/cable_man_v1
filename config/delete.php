<?php

	class Delete extends Connection {

// User Methods Starts ------------------------------------------------------------------------------->

		public function user_profile_ledger_delete($ledger_id,$user_id) {

	    $sql = "INSERT INTO cbl_ledger_backup SELECT * FROM cbl_ledger WHERE ledger_id = '$ledger_id'";
	      
	      if(mysqli_query($this->conn,$sql)) {

	        $sql = "DELETE FROM cbl_ledger WHERE ledger_id = '$ledger_id'";

	          if(mysqli_query($this->conn,$sql)) {

	            $msg = 'Entry Deleted Successfully.';
	            header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

	          } else {

	            $msg = 'Database Error.';
	            header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

	          }
	        }
	    }

// User Methods Ends ------------------------------------------------------------------------------->

// Device Methods Starts ------------------------------------------------------------------------------->

		public function device_delete($dev_id,$user_id) {

			$sql = "DELETE FROM cbl_dev_stock WHERE dev_id ='" . $dev_id . "'";

			if(mysqli_query($this->conn,$sql)) {

			    $msg = 'Device Deleted Successfully!';
			    header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

			  } else {

			    $msg = 'Database Error.';
			    header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);
			  }
			}

		public function release_device($assign_id,$user_id) {

			$sql = "DELETE FROM cbl_user_dev WHERE assign_id ='" . $assign_id . "'";

				if(mysqli_query($this->conn,$sql)) {

				  $msg = 'Device Released from the User!';
				  header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

				} else {

				  $msg = 'Database Error.';
				  header('Location: user_profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

				}
			}

// Device Methods Ends ------------------------------------------------------------------------------->

	}