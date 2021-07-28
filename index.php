<?php
require_once 'vendor/autoload.php';

session_start();
if(isset($_SESSION["loggedin"])){

    if($_SESSION["status"] == "1"){
        
        header('location:twigWelcome.php');
    }

} 

use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Login;

if ($_SERVER['REQUEST_METHOD']=="POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    $common = new Login($db, $email);

    $valid = $common->validUser($email);

    if(!$valid){

        $_SESSION["flash"] = "USER NOT FOUND";

    } else {

        $result = $common->validPass($password, $valid);

        if(!$result){

            $_SESSION["flash"] = "WRONG PASSWORD";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/normalize.css">
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <style>
        .error {
            color:red;
        }
        .valid {
            color:green;
        }
        .warning {
            color: yellow;
        }
        </style>
        <title>Login Page ELMS</title>
</head>
<body>
    <div class="warning">
        <?php
        if (isset($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
        ?>
    </div>
    <span class="error" id="available"></span>
   <div class="center">
       <h1>ELMS LOGIN</h1>
       <form autocomplete="off" novalidate method="POST" id="login">
           <div class="form-group">
               <input name="email" type="email" id="email" placeholder="Enter Your Email Address" autofocus>
           </div>
           <div class="form-group">
               <input name="password" type="password" id="password" placeholder="Enter Your Password">
           </div>
           
           <div>
                <a href="twig/twigForgot.php">Forgot Password ? Click Here</a>
           </div>
           <button id='submit' type="submit">Login</button>
       </form>
   </div>
</body>
</html>
<script src="public/javascript/index.js"></script>