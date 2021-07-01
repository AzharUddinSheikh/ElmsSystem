<?php 

class Database{
    //   connecting to our db
    private $servername = "127.0.0.1:3306";
    private $username = "root";
    private $password = "admin";
    private $dbname = 'elms';
    public $conn;
   
       public function getConnection(){
   
           $this->conn = mysqli_connect( $this->servername ,$this->username,  $this->password, $this->dbname);
   
           return $this->conn;
    }    
   
}

class Department{

    private $dept_name; 
    private $conn;

    public function __construct($dept_name, $db) {
        $this->dept_name = $dept_name;
        $this->conn = $db;
    }

    public function check_dept() {
        
        $existsql = "SELECT * FROM departments WHERE name = '$this->dept_name'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);

    }

    public function create(){

        $query = "INSERT INTO  departments (name) VALUES (?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $this->dept_name);
        
        $stmt->execute();

        $stmt->close();
    }
}

class Login{

    private $conn;
    private $table_name = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    public function valid_pass($form_pass, $row) {
        
        if (password_verify($form_pass, $row["password"])) {

            include 'partials/_sessionstart.php';

            if ($row["user_type"] == '1') {

                header("location:src/admin.php");
                
            } else {
                
                header("location:src/welcome.php");

            }
            
        } else {
            
            die("password doesnot match");
                  
        }
        
    }

    public function valid_user($email) {
  
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

class Email{
    private $email;
    private $empid;

    public static function sendEmail($email, $empid){
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

class Employee{
    
    private $conn;
    private $email;

    public function __construct($db, $email) {

        $this->conn = $db;
        $this->email = $email;
    
    }

    public function create_detail($number, $dob){

        $result = $this->conn->query("SELECT id FROM users WHERE `email`= '$this->email'");
        $last_id = (int)$result->fetch_assoc()["id"];
        $birth_key = 'birthday';
        $phone_key = 'number';
        
        for ($x=0; $x < 2; $x++) {
            
            $query = "INSERT INTO user_details (user_id, user_key, user_value) VALUES(?, ?, ?)";

            $stmt = $this->conn->prepare($query);
           
            if ($x == 0) {
                
                $stmt->bind_param('iss',$last_id ,$birth_key, $dob);
                
            } else {
                
                $stmt->bind_param('isi', $last_id, $phone_key, $number);

            }

            $stmt->execute();
        }

        $stmt->close();

        header('location: ../partials/thankyou.php');
    }

    public function create_user($empid, $fname, $lname, $department, $usertype){

        $query = "INSERT INTO  users (emp_id, first_name, last_name, email, department_id, user_type) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('issssi',$empid, $fname, $lname, $this->email, $department, $usertype);
        
        $stmt->execute();

        $stmt->close();
    }

    public function check_user() {
        $existsql = "SELECT * FROM users Where email = '$this->email'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);
    }
}

class GetEmpId{
    private $conn;
    
    public static function getId($db, $email){

        $sql = "SELECT emp_id FROM users WHERE email = '$email'";
        
        $result = $db->query($sql);
       
        while($row = $result->fetch_assoc()) {
                
            return $row["emp_id"];

          }
    }
}

class SetStatus{
    private $conn;
    
    public static function setToZero($db, $email){

        $sql = "UPDATE users SET status = 0 WHERE email = '$email'";
        
        $db->query($sql);
    }
}

class SetPassword{

    private $resultset;
    private $conn;
    private $id;

    public function __construct($conn, $id){
        $this->conn = $conn;
        $this->id = $id;
        $this->resultset = $conn->query("SELECT * FROM users WHERE status = 0 AND emp_id = '$id' LIMIT 1");
    }

    public function verified(){

        if ($this->resultset->num_rows != 1){

            die("user already verified");
        
        }
    }

    public function updatePass($pass){
      
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

?>