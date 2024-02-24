<?php
class db{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "php_resful_api";
    private $conn;
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->servername,$this->username, $this->password,$this->database);
            //echo "Connected successfully \n";
            } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            }
            return $this->conn;
    }
}
?>