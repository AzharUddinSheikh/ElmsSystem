<?php 

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\SetPassword;

session_start();

if(isset($_GET['empid'])) {

    $id = $_GET['empid'];

    $database = new Database();
    $db = $database->getConnection();

    $passCreate = new SetPassword($db, $id);

    $authorized = $passCreate->verified();
    
    if ($authorized){
       
        $_SESSION["flash"] = "You Are not Authorized";
       
        header("location:../index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        
        if ($pass === $pass1) {
            
            $passCreate->updatePass($pass);

            $_SESSION["flash"] = "Password is Set You May Logged In";
    
            header("location:../index.php");
            
        } 
    }

} else {

    header('location: ../index.php');
}

?>

<html lang="en">
<head>
    <?php include 'header.php';?>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <style>
      .error {
        color:red;
      }
    </style>
    <title>Verified Message</title>
</head>
<body>
    <h1 class="text-center mb-5">You Have Been Verified SET YOUR PASSWORD </h1>
    <form method="POST" id="setpass" name="setpass">
        <div class="d-flex align-items-start flex-column">
            <div class="mb-3 align-self-center">
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password Field">
            </div>
            <div class="mb-3 align-self-center">
                <input type="password" class="form-control" name="pass1" placeholder="Confirm Password Field">
            </div>
            <div class="align-self-center">
                <button type="submit" class="btn btn-primary">SET PASSWORD</button>
            </div>
        </div>
    </form>
</body>
</html>
<script src="../public/javascript/verify.js"></script>