<?php

namespace Azhar\ELMS;
use \mysqli;

class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = 'elms';
    public $conn;

    public function getConnection() : MySQLi
    {
        $this->conn = new mysqli($this->servername, $this->username,  $this->password, $this->dbname);

        return $this->conn;
    }
}

?>