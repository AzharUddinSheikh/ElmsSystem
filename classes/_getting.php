<?php

class DetailEmp
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->sql = "SELECT * FROM users JOIN departments WHERE users.id = departments.id AND users.status != 0";
        $this->result = $this->conn->query($this->sql);
    }
        
    public function showemp() 
        {
            
            if ($this->result->num_rows > 0) {
            
                return true;
            
            } else {
            
                return false;
            
            }
            
        }
}

class GetEmpId
{
    private $conn;
    
    public static function getId($db, $email){

        $sql = "SELECT emp_id FROM users WHERE email = '$email'";
        
        $result = $db->query($sql);
       
        while($row = $result->fetch_assoc()) {
                
            return $row["emp_id"];
          }
    }
}

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