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

    private $table_name = "departments";
    private $dept_name; 
    private $conn;

    public function __construct($dept_name, $db) {
        $this->dept_name = $dept_name;
        $this->conn = $db;
    }

    public function check_dept() {
        
        $existsql = "SELECT * FROM $this->table_name WHERE name = '$this->dept_name'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);

    }

    public function create(){

        $query = "INSERT INTO  $this->table_name (name, added_on) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $date = date("Y-m-d h:i:s");

        $stmt->bind_param('ss', $this->dept_name, $date);
        
        $stmt->execute();

        $smtp->close();
        
        header("location:admin.php");
        
    }
}

class Login{

    private $conn;
    private $table_name = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    public function valid_pass($form_pass, $db_pass) {
        
        if (password_verify($form_pass, $db_pass)) {

            include 'partials/_sessionstart.php';
            
            header("location:src/admin.php");
            
        } else {
            
            die("password doesnot match");
                  
        }
        
    }

    public function valid_user($email) {
  
        $sql = "SELECT * FROM $this->table_name where email = '$email'";
  
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                
                return $row["password"];
              }
              
        } else {

              die("user not found");
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
            
            if ($x == 0) {
                $query = "INSERT INTO user_details (user_id, user_key, user_value) VALUES(?, ?, ?)";

                $stmt = $this->conn->prepare($query);
                
                $stmt->bind_param('iss',$last_id ,$birth_key, $dob);
                
                $stmt->execute();
                
            } elseif ($x == 1) {
                
                $query = "INSERT INTO user_details (user_id, user_key, user_value) VALUES(?, ?, ?)";

                $stmt = $this->conn->prepare($query);
               
                $stmt->bind_param('isi', $last_id, $phone_key, $number);

                $stmt->execute();
            }
        }

        $stmt->close();

        header('location: ../partials/thankyou.php');
    }

    public function create_user($empid, $fname, $lname, $department, $usertype){

        $query = "INSERT INTO  users (emp_id, first_name, last_name, email, department_id, user_type, added_on) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $date = date("Y-m-d h:i:s");

        $stmt->bind_param('issssis',$empid, $fname, $lname, $this->email, $department, $usertype, $date);
        
        $stmt->execute();

        $stmt->close();
    }

    public function check_user() {
        $existsql = "SELECT * FROM users Where email = '$this->email'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);
    }
}

?>