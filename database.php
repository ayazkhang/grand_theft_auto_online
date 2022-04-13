<?php

class Database {

    /* Properties */
    public $conn;
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=test", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "";
            die();
        }
        return $this->conn;
    }

}
