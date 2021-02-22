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
					u.user_id,
					u.first_name,
					u.last_name,
					u.mobile_no,
					u.address,
					u.install_date,
					u.user_status,
					ar.a_name
					FROM tbl_user u
					LEFT JOIN tbl_area ar ON ar.area_id = u.area_id
					WHERE u.user_status = 1
					ORDER BY u.install_date DESC
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
					SELECT
					m.map_id,
					dv.dev_id,
					u.user_id,
					dv.dev_no,
					CASE
						WHEN dv.dev_type = 1 THEN '[SD]'
						WHEN dv.dev_type = 2 THEN '[HD]'
					END AS dev_type,
					pc.mso_name
					FROM
					tbl_mapping m
					LEFT JOIN tbl_user u ON u.user_id = m.user_id
					RIGHT JOIN tbl_device dv ON dv.dev_id = m.dev_id
					RIGHT JOIN tbl_package pc ON pc.pack_id = dv.pack_id
					WHERE m.user_id = '$user_id'
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

		public function fetch_profile_base($user_id) {

			$sql = "
						SELECT
						u.user_id,
						u.first_name,
						u.last_name,
						u.mobile_no,
						u.address,
						u.install_date,
						ar.a_name
						FROM tbl_user u
						LEFT JOIN tbl_area ar ON ar.area_id = u.area_id
						WHERE user_id = '$user_id'
					";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

		public function fetch_device_list() {

			$sql = "
					SELECT
					dv.dev_id,
					dv.dev_no,
					dv.dev_type,
					pc.pc_name,
					pc.pc_rate,
					pc.mso_name

					FROM tbl_device dv
					LEFT JOIN tbl_package pc ON pc.pack_id = dv.pack_id
					ORDER BY dv.created_at
					";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function fetch_mso_list() {

			return $this->conn->query("SELECT * FROM tbl_mso");

			$this->conn->close();

		}

		public function franchise_list() {

			$sql = "
					SELECT
					fr.fr_id,
					fr.fr_name,
					fr.gst_no,
					fr.landline_no,
					fr.mobile_no,
					fr.fr_address,
					ar.a_name

					FROM tbl_franchise fr
					LEFT JOIN tbl_area ar ON ar.area_id = fr.area_id
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

		public function fetch_staff_detail_list() {

			$sql = "
					SELECT
					sf.username,
					CONCAT(sf.first_name,' ',sf.last_name) AS full_name,
					sf.mobile_no,
					CASE
						WHEN sf.staff_position = 1 THEN 'Admin'
						WHEN  sf.staff_position = 2 THEN 'Agent'
					END AS staff_position,
					fr.fr_name
					FROM tbl_staff sf
					LEFT JOIN tbl_franchise fr ON fr.fr_id = sf.fr_id
					";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function fetch_package_list() {

			$sql = "SELECT * FROM tbl_package";

			return $this->conn->query($sql);

			$this->conn->close();

		}

		public function fetch_package_list_all() {

			return $this->conn->query("SELECT * FROM tbl_package");

		}

	}