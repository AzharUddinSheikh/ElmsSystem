<?php 

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\SetPassword;

if(isset($_GET['empid'])) {

    $id = $_GET['empid'];

    $database = new Database();
    $db = $database->getConnection();

    $passCreate = new SetPassword($db, $id);

    $passCreate->verified();
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        
        if ($pass === $pass1) {
            
            $passCreate->updatePass($pass);
    
            header("location:../index.php");
            
        } else {
            
            echo '<script>alert("Password doesnot Match")</script>';
            
        }
        
    }
} else {

    header('location: ../index.php');
}

?>

<html lang="en">
<head>
    <?php include 'header.php';?>
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
</body>
</html>