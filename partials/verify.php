<?php 

include '../src/_db.php';

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

if(isset($_GET['empid'])) {

    $id = $_GET['empid'];

    $database = new Database();
    $db = $database->getConnection();

    $passCreate = new SetPassword($db, $id);

    $passCreate->verified();
    
    if ($_SERVER['REQUEST_METHOD']=="POST") {
        
        $pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        
        if ($pass === $pass1) {
            
            $passCreate->updatePass($pass);
    
            header("location:../index.php");
        
        } else {
    
            die("password and confirm password should be equal");
        
        }
    
    }
} else {

    die("Something went wrong may be you are not authorized");

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Verified Message</title>
</head>
<body>
    <h1 class="text-center mb-5">You Have Been Verified SET YOUR PASSWORD </h1>
    
    <form method="POST">
        <div class="d-flex align-items-start flex-column">
            <div class="mb-3 align-self-center">
                <input type="password" class="form-control" name="pass" placeholder="Password Field">
            </div>
            <div class="mb-3 align-self-center">
                <input type="password" class="form-control" name="pass1" placeholder="Confirm Password Field">
            </div>
            <div class="align-self-center">
                <button type="submit" class="btn btn-primary">SET PASSWORD</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>