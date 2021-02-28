<?php

	class Organ extends Connection {

  // Function to SELECT from the database
  public function select($table, $rows = '*', $join = null, $where = null, $group = null, $order = null, $limit = null) {
    // Create query from the variables passed to the function
    $q = 'SELECT '.$rows.' FROM '.$table;
    if($join != null) {
      $q .= ' JOIN '.$join;
    }
        if($where != null) {
          $q .= ' WHERE '.$where;
    }
        if($group != null) {
            $q .= ' GROUP BY '.$group;
    }
        if($order != null) {
            $q .= ' ORDER BY '.$order;
    }
        if($limit != null) {
            $q .= ' LIMIT '.$limit;
        }
        // echo $table;
        return $this->conn->query($q);
    }

    // Escape string
    public function escapeString($data) {

      return $this->conn->real_escape_string($data);

    }

// Basic query.
    public function query($sql) {

      return $this->conn->query($sql);

    }

  // Function to insert into the database
    public function insert($table, $params = array()) {

        $sql = 'INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';

        // Submit query to database
          return $this->conn->query($sql);

    }

  // Function to update row in database
    public function update($table, $params = array(), $where) {

      // Create Array to hold all the columns to update
        $args = array();

      foreach($params as $field=>$value) {

        // Seperate each column out with it's corresponding value
        $args[] = $field.'="'.$value.'"';

      }

      // Create the query
      $sql = 'UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;

      // Make query to database
        return $this->conn->query($sql);

    }

    public function insert_id() {

      return $this->conn->insert_id;

    }

  //Function to delete table or row(s) from database
    public function delete($table,$where = null) {

        if($where == null) {

                $delete = 'DROP TABLE '.$table; // Create query to delete table

            } else {

                $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows

            }
            // Submit query to database
            return $this->conn->query($delete);
    }

    function num_rows($query) {

        $result  = $this->conn->query($query);

        $row_count = $result->num_rows;

        return $row_count;

    }

    /**
     * Read finctions from below
     */

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

      public function renewal_wizard($device_id) {

              $sql = "
            SELECT
            m.user_id,
            d.device_id,
            d.device_no,
            d.device_type,
            pc.mso_name,
            pc.pack_code

            FROM tbl_mapping m

            LEFT JOIN tbl_device d ON d.device_id = m.device_id
            LEFT JOIN tbl_package pc ON pc.package_id = d.package_id
            WHERE m.device_id = '$device_id'
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
          m.mapped_id,
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

    public function device_list() {

      $sql = "
          SELECT
          dv.device_id,
          dv.device_no,
          dv.device_type,
          pc.pack_code,
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

    public function staff_list() {

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