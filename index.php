<?php
require_once 'vendor/autoload.php';

include 'classes/_common.php';

if ($_SERVER['REQUEST_METHOD']=="POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    $common = (new Login($db, $email));

    $valid =$common->validUser($email);

    $common->validPass($password, $valid);

}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page ELMS</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
   <div class="center">
       <h1>ELMS LOGIN</h1>
       <form autocomplete="off" novalidate method="POST">
           <div class="form-group">
               <input name="email" type="email" id="email" placeholder="Enter Your Email Address" autofocus>
           </div>
           <div class="form-group">
               <input name="password" type="password" id="password" placeholder="Enter Your Password">
           </div>
           <div>
                <a href="src/forgot.php">Forgot Password ? Click Here</a>
           </div>
           <button type="submit">Login</button>
       </form>
   </div>
</body>
</html>