<?php

namespace Azhar\ELMS;
use \mysqli;

class Database
{
    private string $servername = "127.0.0.1:3307";
    private string $username = "root";
    private string $password = "";
    private string $dbname = 'elms';
    public object $conn;

    public function getConnection() : MySQLi
    {
        $this->conn = new mysqli($this->servername, $this->username,  $this->password, $this->dbname);

        return $this->conn;
    }
}

?>