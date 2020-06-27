<?php

class Database
{
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "3457350_apidb";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=".$this->port.";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $pdoException) {
            echo "Connection error: " . $pdoException->getMessage();
        }
        return $this->conn;
    }
}

?>