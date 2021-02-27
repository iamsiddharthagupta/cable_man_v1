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

}