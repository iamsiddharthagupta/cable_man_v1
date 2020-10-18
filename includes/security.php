<?php

	class Security extends Connection {

	public function login() {

			if(isset($_POST['submit'])) {

			$username = stripcslashes($_POST['username']);
			$password = stripcslashes($_POST['password']);
			$username = mysqli_real_escape_string($this->conn,$username);
			$password = mysqli_real_escape_string($this->conn,$password);

			// Hashing Passkeys    
			$password = md5($password);

			if(!empty($username) && !empty($password)) {

				$sql = "SELECT * FROM tbl_auth WHERE username = '$username' AND password = '$password' LIMIT 1";
				$result = mysqli_query($this->conn,$sql);

				$row = mysqli_num_rows($result);
				$data = mysqli_fetch_assoc($result);

				$user_level = intval($data['user_level']);

				if($row == 1) {

				if($user_level == 1) {

					$_SESSION['curr_user'] = $data['full_name'];
					$_SESSION['user_level'] = $user_level;
					header('Location: dashboard.php');

				} else if($user_level == 2) {
				  
					$_SESSION['curr_user'] = $data['full_name'];
					$_SESSION['user_level'] = $user_level;
					header('Location: agent_panel.php');

				} else {

					$msg = 'Failed to authenticate user level.';
					header('Location: index.php?msg='.$msg);

				}

				} else {

					$msg = 'Failed to authenticate.';
					header('Location: index.php?msg='.$msg);

				}

				} else {

					$msg = 'Please enter credentials.';
					header('Location: index.php?msg='.$msg);

				}

			}
	}

	public function session($curr_user, $user_level) {

		if(isset($user_level)) {
		  
		  $curr_user = ucwords($curr_user);
		  
		  if($user_level != 1) {
		  
			header('Location: agent_panel.php');
		  
		  }

		} else {

			header('Location: index.php');

		}

	}

}