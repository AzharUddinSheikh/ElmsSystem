<?php 

require_once '../vendor/autoload.php';

session_start();

use Azhar\Elms\Common\Email;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\SetStatus;
use Azhar\Elms\Getting\GetEmpId;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];
   
    $database = new Database();
    $db = $database->getConnection();

    SetStatus::setToZero($db, $email);
    
    if (Email::sendEmail($email, GetEmpId::getId($db, $email))) {

        $_SESSION["flash"] = "Reset Link Has Been Sent To Registered Email";

    } 

    header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../partials/header.php';?>
    <title>forgot password</title>
</head>
<body>
    <div class="w-50 mx-auto text-center">
        <h1 class="mt-5">Forgot Password</h1>
        <form class="w-30 my-5" method="POST">
            <div class="mb-3">
                <input name="email" type="email" class="form-control" id="email" placeholder="Email Address">
            </div>
            <div class="mb-3" id="available"></div>
            <div class="submit">
                <button id="search" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <script src="../public/javascript/forgot.js"></script>
</body>
</html>
                