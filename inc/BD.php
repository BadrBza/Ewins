<?php

namespace inc;

class BD
{
    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $database = 'Q220251';
    public $conn;

    public function __construct()
    {
        $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }
}
