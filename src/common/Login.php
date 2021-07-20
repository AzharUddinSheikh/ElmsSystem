<?php

namespace Azhar\ELMS\Common;

class Login
{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function validPass($form_pass, $row) 
    {
        if (password_verify($form_pass, $row["password"])) {

            include 'partials/_sessionstart.php';

            if ($row["user_type"] == '1') {

                header("location:view/admin.php");
                
            } else {
                
                header("location:view/welcome.php");
            }
        }
    }

    public function validUser($email) 
    {
  
        $sql = "SELECT * FROM users u JOIN user_details ud WHERE u.id = ud.user_id AND email='$email'";
  
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                
                return $row;
              }
        } 
    }

    public function checkPassword($id, $oldpass)
    {
        $sql = "SELECT * FROM users WHERE users.id = '$id' LIMIT 1"; 

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        if (!password_verify($oldpass, $row["password"])) {
        
            return false;
        
        } else {

            return true;
        }
    }
}

?>