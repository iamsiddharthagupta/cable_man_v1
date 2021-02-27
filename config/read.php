<?php

	class Read extends Connection {

	    public function user_list() {

			$sql = " 
					SELECT
					u.user_id,
					u.first_name,
					u.last_name,
					u.mobile_no,
					u.address,
					u.install_date,
					u.user_status,
					ar.area
					FROM tbl_user u
					LEFT JOIN tbl_area ar ON ar.area_id = u.area_id
					WHERE u.user_status = 1
					ORDER BY u.install_date DESC
			      ";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

		public function profile_base($user_id) {

			$sql = "
						SELECT
						u.user_id,
						u.first_name,
						u.last_name,
						u.mobile_no,
						u.address,
						u.install_date,
						ar.area
						FROM tbl_user u
						LEFT JOIN tbl_area ar ON ar.area_id = u.area_id
						WHERE user_id = '$user_id'
					";

			return $this->conn->query($sql);

			$this->conn->close();

	    }

	    public function profile_ledger($user_id) {

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

	    public function renewal_wizard($user_id, $dev_id) {

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

		public function payment_wizard($ledger_id) {

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

		public function mapped_device($user_id) {

		    $sql = "
					SELECT
					m.map_id,
					dv.device_id,
					u.user_id,
					dv.device_no,
					CASE
						WHEN dv.device_type = 1 THEN '[SD]'
						WHEN dv.device_type = 2 THEN '[HD]'
					END AS device_type,
					pc.mso_name
					FROM
					tbl_mapping m
					LEFT JOIN tbl_user u ON u.user_id = m.user_id
					RIGHT JOIN tbl_device dv ON dv.device_id = m.device_id
					RIGHT JOIN tbl_package pc ON pc.package_id = dv.package_id
					WHERE m.user_id = '$user_id'
		            ";

			return $this->conn->query($sql);

			$this->conn->close();

		}

	    public function device_selector($user_id) {

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

		public function device_list() {

			$sql = "
					SELECT
					dv.device_id,
					dv.device_no,
					dv.device_type,
					pc.pack_name,
					pc.pack_rate,
					pc.mso_name

					FROM tbl_device dv
					LEFT JOIN tbl_package pc ON pc.package_id = dv.package_id
					ORDER BY dv.created_at
					";

			return $this->conn->query($sql);

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
					fr.address,
					ar.area

					FROM tbl_franchise fr
					LEFT JOIN tbl_area ar ON ar.area_id = fr.area_id
					";

			return $this->conn->query($sql);

			$this->conn->close();
			
		}

		public function fetch_staff_detail_list() {

			$sql = "
					SELECT
					sf.username,
					sf.first_name,
					sf.last_name,
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

	}