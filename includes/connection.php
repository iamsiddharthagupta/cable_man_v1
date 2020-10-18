<?php

  // Setting up Indian timezone.
  date_default_timezone_set("Asia/Kolkata");

  require_once 'config.php';

    class Connection {

      public $conn;

      function __construct() {

        $this->open_db_connection();

      }

      public function open_db_connection() {
        
        $this->conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

      if($this->conn->connect_errno) {

        die("Database Error." . $this->conn->connect_error);

      }
    }
  }

  $database = new Connection();

?>