<?php

namespace CommonClass;

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

class InActivity
{
    public static function inActive($session_time) 
    {
        if ((time() - $session_time) > 1800) {
            header("location: ../partials/logout.php");
        } else {
            $session_time = time();
        }
    }
}

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

                header("location:src/admin.php");
                
            } else {
                
                header("location:src/welcome.php");
            }
            
        } else {
            
            echo '<script>alert("Invalid Password")</script>';
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
              
        } else {

              die("user not found valid_user method");
        }   
    }
}

class Email
{
    private $email;
    private $empid;

    public static function sendEmail($email, $empid)
    {
        $to = $email;
        $subject = "ELMS Employee Email Verification";
        $message = "<a href=http://localhost/elms/partials/verify.php?empid=$empid>Verified Your Account</a>";
        $headers = 'From: azharsheikh760@gmail.com'       . "\r\n" .
                    'Reply-To: azharsheikh760@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        if (!mail($to, $subject, $message, $headers)) {

            die("mail has not been send to registered email, Registration Failed");
        }   
    }
}

?>