<?php

namespace Azhar\ELMS\Getting;

class GetLeave
{
    private $sql;
    private $conn;

    public function __construct($db) 
    {
        $this->conn = $db;
    }
    
    public function leaveRequest()
    {
        $sql = "SELECT * FROM users JOIN leave_requests WHERE users.id = leave_requests.user_id AND leave_requests.status = 0";
        
        $result = $this->conn->query($sql);
        
        return $result;
    }
    
    public function userLeave($id)
    {
        $sql = "SELECT * FROM leave_requests WHERE user_id = '$id'";
    
        $result = $this->conn->query($sql);
    
        return $result;
    }
}

?>