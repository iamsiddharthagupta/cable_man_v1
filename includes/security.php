<?php

	class Security extends Connection {

		public function login() {

			if(isset($_POST['submit'])) {

				$username = $this->conn->real_escape_string(stripcslashes($_POST['username']));
				$password = $this->conn->real_escape_string(stripcslashes(md5($_POST['password'])));

				if(!empty($username) && !empty($password)) {

					$result = $this->conn->query("SELECT *, CONCAT(first_name,' ',last_name) AS logged_staff FROM tbl_staff WHERE username = '$username' AND password = '$password' LIMIT 1");

					$row = $result->fetch_assoc();

					if($result->num_rows > 0) {

						$_SESSION['staff_id'] = $row['staff_id'];
						$_SESSION['logged_staff'] = $row['logged_staff'];
						header('Location: dashboard.php');

					} else {

						$msg = 'Authentication Failed.';
						header('Location: index.php?msg='.$msg);

					}

				} else {

						$msg = 'Please enter credentials.';
						header('Location: index.php?msg='.$msg);

				}
			}
		}

}