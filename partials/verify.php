<?php 

include '../classes/_common.php';
include '../classes/_updating.php';

use CommonClass\Database;
use UpdatingDetail\SetPassword;

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