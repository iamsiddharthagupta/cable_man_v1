<?php

	class Read extends Connection {

	    public function user_profile_ledger_fetch($user_id) {

			$sql = "
                    SELECT
                      d.dev_id,
                      d.device_no,
                      d.device_mso,
                      l.ledger_id,
                      l.renew_date,
                      l.expiry_date,
                      l.renew_term,
                      l.due_amount,
                      l.pay_amount,
                      l.pay_balance,
                      CASE
                        WHEN l.pay_status IS NULL THEN '-'
                        ELSE l.pay_status
                      END AS pay_status,
                      CASE
                        WHEN l.pay_date IS NULL THEN 'Unpaid'
                        ELSE DATE_FORMAT(l.pay_date, '%e %b %Y')
                      END AS pay_date,
                      l.ledger_status,
                      l.user_id

                      FROM cbl_user_dev ud

                      RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
                      LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
                      LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

                      WHERE l.user_id = '$user_id'
                      ORDER BY renew_date DESC
                  ";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

	    public function fetch_list_customer() {

			$sql = " 
					SELECT
					cu.cust_id,
					cu.first_name,
					cu.last_name,
					cu.phone_no,
					cu.address,
					cu.install_date,
					cu.customer_status,
					ar.area_name
					FROM tbl_customer cu
					LEFT JOIN tbl_area ar ON cu.area_id = ar.area_id
					WHERE cu.customer_status = 1
					GROUP BY cu.cust_id
					ORDER BY cu.install_date DESC
			      ";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

	    public function user_list_disconnect() {

		    $sql = " SELECT
		              u.user_id,
		              u.first_name,
		              u.last_name,
		              u.phone_no,
		              u.address,
		              u.area,
		              u.doi,
		              u.user_status,
		              SUM(d.package) AS package,
		              COUNT(ud.dev_id) AS device_count,
		              ud.dev_id,
		              CASE
		                WHEN u.user_status = 0 THEN 'Disconnected'
		                WHEN ud.dev_id IS NULL THEN 'Device Unmapped'
		              END AS user_status

		              FROM cbl_user_dev ud

		              RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
		              LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
		              WHERE u.user_status = 0 OR ud.dev_id IS NULL
		              GROUP BY u.user_id
		              ORDER BY u.doi DESC
		          ";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

		public function user_list_active() {

			$sql = "
			          SELECT
			          u.user_id,
			          u.first_name,
			          u.last_name,
			          u.phone_no,
			          u.address,
			          u.area,
			          d.dev_id,
			          d.device_no,
			          d.device_mso,
			          l.ledger_id,
			          MAX(l.renew_date) AS renew_date,
			          MAX(l.expiry_date) AS expiry_date,
			          CASE
			            WHEN l.pay_amount = 0 THEN 'Due'
			            ELSE 'Paid'
			          END AS status

			          FROM cbl_ledger l

			          LEFT JOIN cbl_user u ON u.user_id = l.user_id
			          RIGHT JOIN cbl_user_dev ud ON ud.dev_id = l.dev_id
			          RIGHT JOIN cbl_dev_stock d ON d.dev_id = l.dev_id

			          WHERE u.user_status = 1
			          GROUP BY l.dev_id
			          ORDER BY l.expiry_date ASC
			        ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function user_list_scheme() {

			$sql = "
			          SELECT
			          u.user_id,
			          u.first_name,
			          u.last_name,
			          u.phone_no,
			          u.address,
			          u.area,
			          d.package,
			          d.dev_id,
			          d.device_no,
			          d.device_mso,
			          MAX(l.renew_date) AS renew_date,
			          MAX(l.expiry_date) AS expiry_date,
			          l.ledger_id,
			          l.renew_term,
			          SUM(l.pay_amount) AS pay_amount,
			          CASE
			            WHEN CURDATE() = l.expiry_date THEN '(Expiring)'
			          END AS ledger_status

			          FROM cbl_user_dev ud

			          RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
			          RIGHT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
			          LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

			          WHERE u.user_status = 1 AND CURDATE() BETWEEN l.renew_date AND l.expiry_date AND l.renew_term > 1
			          GROUP BY u.user_id
			          ORDER BY l.expiry_date ASC
			        ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function user_list_expired() {

			$sql = "
			          SELECT
			          u.user_id,
			          u.first_name,
			          u.last_name,
			          u.phone_no,
			          u.address,
			          u.area,
			          d.package,
			          d.dev_id,
			          d.device_no,
			          d.device_mso,
			          MAX(l.expiry_date) AS expiry,
			          l.ledger_id

			          FROM cbl_user_dev ud
			          
			          RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
			          RIGHT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
			          LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

			          WHERE u.user_status = 1 AND l.user_id NOT IN (SELECT user_id FROM cbl_ledger WHERE expiry_date > CURDATE())

			          GROUP BY u.user_id
			          ORDER BY l.expiry_date ASC
			        ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function user_list_unpaid() {

			$sql = "
			          SELECT
			          u.user_id,
			          u.first_name,
			          u.last_name,
			          u.address,
			          u.area,
			          u.phone_no,
			          SUM(l.renew_term) AS months,
			          SUM(l.due_amount) AS dues,
			          l.user_id,
			          l.ledger_id

			          FROM cbl_user_dev ud
			          RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
			          LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
			          WHERE l.ledger_status = 'Renewed'
			          GROUP BY l.user_id
			          ORDER BY months DESC
			        ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function pay_receipt($ledger_id) {

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

		          WHERE ledger_id = '$ledger_id'
		        ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

	    public function user_profile_renewal_fetch($user_id, $dev_id) {

	            $sql = "
	                    SELECT
	                    ud.user_id,
	                    d.dev_id,
	                    d.device_no,
	                    d.package,
	                    d.device_mso,
	                    d.device_type,
	                    CASE
	                      WHEN l.renew_date IS NULL THEN 'Unavailable'
	                      ELSE MAX(l.renew_date)
	                    END AS last_renewal,
	                    MAX(l.renew_date) AS renew_date,
	                    MAX(l.expiry_date) AS expiry_date

	                    FROM cbl_user_dev ud

	                    LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id
	                    LEFT JOIN cbl_ledger l ON l.user_id = ud.user_id
	                    WHERE ud.dev_id = '$dev_id' AND ud.user_id = '$user_id'
	                  ";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

		public function user_profile_payment_fetch($ledger_id) {

			$sql = "
					SELECT
					d.device_no,
					d.device_mso,
					l.renew_date,
					l.expiry_date,
					l.renew_month,
					l.invoice_no,
					l.due_amount,
					l.pay_balance,
					l.ledger_id,
					l.user_id

					FROM cbl_user_dev ud

					RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
					LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
					LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

					WHERE l.ledger_id = '$ledger_id'
			        ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function fetch_area_list() {

			return $this->conn->query("SELECT * FROM tbl_area");

			$this->conn->close();

		}

		public function device_edit_fetch($dev_id) {

		    $sql = "SELECT * FROM tbl_device WHERE dev_id = '$dev_id'";

		   	return $this->conn->query($sql);

		}

		public function user_profile_device_fetch($user_id) {

		    $sql = "
		            SELECT * FROM cbl_user_dev
		            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
		            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
		            WHERE cbl_user_dev.user_id = '$user_id'
		            ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

	    public function user_profile_select_device_fetch($user_id) {

			$sql = "
			      SELECT
			      ud.user_id,
			      d.dev_id,
			      d.device_no,
			      d.device_mso,
			      d.device_type,
			      MAX(l.renew_date) AS renew_date,
			      MAX(l.expiry_date) AS expiry_date

			      FROM cbl_user_dev ud

			      LEFT JOIN cbl_ledger l ON l.user_id = ud.user_id
			      LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

			      WHERE ud.user_id = '$user_id'
			      GROUP BY d.device_no
			    ";
			
			return $this->conn->query($sql);

			$this->conn->close();

		}

// New Functions from below ----------------->

		public function fetch_profile_base($cust_id) {

			$sql = "
						SELECT
						CONCAT(cu.first_name,' ',cu.last_name) AS full_name,
						cu.phone_no,
						cu.address,
						cu.install_date,
						ar.area_name
						FROM tbl_customer cu
						LEFT JOIN tbl_area ar ON ar.area_id = cu.area_id
						WHERE cust_id = '$cust_id'
					";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

		public function fetch_device_list() {

			$sql = "SELECT * FROM tbl_device ORDER BY edited_at";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function fetch_mso_list() {

			return $this->conn->query("SELECT * FROM tbl_mso");

			$this->conn->close();

		}

		public function fetch_branch_list() {

			$sql = "
					SELECT

					br.branch_name,
					br.branch_gst,
					br.branch_landline,
					br.branch_mobile,
					br.branch_address,
					ar.area_name

					FROM tbl_branch br
					LEFT JOIN tbl_area ar ON ar.area_id = br.area_id
					";

			return $this->conn->query($sql);

			$this->conn->close();
			
		}

		public function fetch_staff_details($staff_id) {

	        $sql = "
						SELECT
							CONCAT(first_name,' ',last_name) AS full_name,
							phone_no,
							CASE
							  WHEN staff_position = 1 THEN 'Admin'
							  ELSE 'Agent'
							END AS staff_position
						FROM tbl_staff
						WHERE staff_id = '$staff_id'
	                ";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

		public function fetch_branch_list_all() {

			return $this->conn->query("SELECT * FROM tbl_branch");

			$this->conn->close();

		}

		public function fetch_staff_detail_list() {

			$sql = "
					SELECT

					stf.username,
					CONCAT(stf.first_name,' ',stf.last_name) AS full_name,
					stf.phone_no,
					CASE
						WHEN stf.staff_position = 1 THEN 'Admin'
						WHEN  stf.staff_position = 2 THEN 'Agent'
					END AS staff_position,
					bra.branch_name

					FROM tbl_staff stf
					LEFT JOIN tbl_branch bra ON bra.branch_id = stf.branch_id

					";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function fetch_package_list() {

			$sql = "	SELECT

						pk.pack_name,
						pk.pack_price,
						pk.pack_type,
						pk.pack_duration,
						ms.mso_name


						FROM tbl_package pk
						LEFT JOIN tbl_mso ms ON pk.mso_id = ms.mso_id
					";

			return $this->conn->query($sql);

			$this->conn->close();

		}

	}