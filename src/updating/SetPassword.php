<?php

namespace Azhar\ELMS\Updating;

class SetPassword
{
    private $resultset;
    private $conn;
    private $id;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->resultset = $conn->query("SELECT * FROM users WHERE status = 0 AND emp_id = '$id' LIMIT 1");
    }

    public function verified()
    {
        if ($this->resultset->num_rows != 1){

            return true;
        }
    }

    public function updatePass($pass)
    {
        if ($this->resultset->num_rows == 1) {
            
            $setPass = password_hash($pass, PASSWORD_DEFAULT);

            $update = $this->conn->query("UPDATE users SET password = '$setPass',status = 1 WHERE emp_id = '$this->id' LIMIT 1");
        } 
    }
}

?>