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

class Login{

    private $conn;
    private $table_name = "users";
    public $email;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // method for checking valid password
    public function valid_pass($form_pass, $db_pass) {
        
        if (password_verify($form_pass, $db_pass)) {

            include 'partials/_sessionstart.php';
            
            header("location:src/admin.php");
            
        } else {
            
            die("password doesnot match");
                  
        }
        
    }

    // method for checking valid username
    public function valid_user($email) {
  
        $sql = "SELECT * FROM $this->table_name where email = '$email'";
  
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                
                $valid_user_pass = $row["password"];

                return $valid_user_pass;
    
              }
              
          } else {

              die("user not found");

          }
          
    }
}

?>