<?php

namespace Azhar\ELMS;

class Database
{
    private $servername = "127.0.0.1:3306";
    private $username = "root";
    private $password = "admin";
    private $dbname = 'elms';
    public $conn;
   
    public function getConnection()
    {
        $this->conn = mysqli_connect($this->servername, $this->username,  $this->password, $this->dbname);

        return $this->conn;
    }       
   
}

?>