<?php

namespace Azhar\ELMS\Getting;

class GetLeave
{
    private $sql;
    private $conn;

    public function __construct($db, $id) 
    {
        $this->conn = $db;
        $this->sql = "SELECT * FROM users JOIN leave_requests WHERE users.id = leave_requests.user_id AND leave_requests.status = 0";
        $this->result = $this->conn->query($this->sql);
        $this->sql1 = "SELECT * FROM leave_requests WHERE user_id = '$id'";
        $this->result1 = $this->conn->query($this->sql1);
    }
    public function leaveRequest()
    {
        if($this->result->num_rows > 0) {
            
            return true;
        
        } else {
        
            return false;
        
        }
    }

    public function userLeave()
    {
        if($this->result1->num_rows > 0) {
            
            return true;
        
        } else {

            return false;
        }
    }
}

?>