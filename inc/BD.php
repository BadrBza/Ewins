<?php
namespace inc;

class BD {
    private $host = '192.168.132.203';
    private $username = 'Q220251';
    private $password = '7f91b28807eaf65138b621063d4015e616364286';
    private $database = 'Q220251';
    public $conn;

  

    public function __construct() {
        $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database);


        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }
}

?>