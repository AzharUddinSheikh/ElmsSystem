<?php

class ChangePassword
{
    public static function changePass($email, $pass, $db)
    {
        $sql = "UPDATE users SET password = '$pass' WHERE email = '$email'";

        $db->query($sql);

        echo "password changed successfully";
    } 
}

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

            die("user already verified");
        
        }
    }

    public function updatePass($pass)
    {
        if ($this->resultset->num_rows == 1) {
            
            $setPass = password_hash($pass, PASSWORD_DEFAULT);

            $update = $this->conn->query("UPDATE users SET password = '$setPass',status = 1 WHERE emp_id = '$this->id' LIMIT 1");

            if (!$update) {
               
                die("Update Failed: Already Verified or Login With Default Password");
            
            }

        } else {

            die("setting password result not found");

        }
    }

}


class SetStatus
{
    private $conn;
     
    public static function setToZero($db, $email)
    {
        $sql = "UPDATE users SET status = 0 WHERE email = '$email'";
        
        $db->query($sql);
    }
}

?>