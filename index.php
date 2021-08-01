<?php
require_once 'vendor/autoload.php';

session_start();
if(isset($_SESSION["loggedin"])){

    if($_SESSION["status"] == "1"){
        
        header('location:twig/twigWelcome.php');
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

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <title>Login Page ELMS</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
      <span class="alert alert-danger" id="available" role="alert"></span>
      <?php
      if (isset($_SESSION["flash"])){
          echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION["flash"];
            '</div>';
          unset($_SESSION["flash"]);
        }
      ?>
    <form class="form-signin" autocomplete="off" novalidate method="POST" id="login">
      <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">ELMS LOGIN </h1>
      <div class="mb-3">
        <input class="form-control" name="email" type="email" id="email" placeholder="Enter Your Email Address" autofocus>
      </div>
      <input class="form-control" name="password" type="password" id="password" placeholder="Enter Your Password">
      <div class="mb-3">
        <a href="twig/twigForgot.php">Forgot Password ? Click Here</a>
      </div>
      <button class="btn btn-lg btn-primary btn-block" id='submit' type="submit">Log In</button>
    </form>
  </body>
</html>
<script src="public/javascript/index.js"></script>
