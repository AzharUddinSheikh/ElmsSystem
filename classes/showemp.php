<?php

class DetailEmp
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->sql = "SELECT * FROM users JOIN departments WHERE users.id = departments.id";
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
 // showing the all employee to admin

?>