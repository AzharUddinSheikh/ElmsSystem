<?php
require_once 'vendor/autoload.php';

session_start();

if(isset($_SESSION["loggedin"])){

    if($_SESSION["user"] == "0"  && ($_SESSION["status"] == "1")){
        
        header('location:twig/welcome.php');
        
      } elseif ($_SESSION["user"] == "1"  && ($_SESSION["status"] == "1")) { 
        
        header('location: twig/admin.php');
      
      } 
} 

use Azhar\Elms\Common\Database;
use Azhar\Elms\Users;

$database = new Database();
$db = $database->getConnection();

$users = new Users($db);

if(isset($_SESSION["flash"])){
  unset($_SESSION["flash"]);
}

if ($_SERVER['REQUEST_METHOD']=="POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $valid = $users->validUser($email);

    if(!$valid){

        $_SESSION["flash"] = "USER NOT FOUND";

    } else {

        $result = $users->validPass($password, $valid);

        if(!$result){

            $_SESSION["flash"] = "WRONG PASSWORD";
        }
    }
}

$loader = new \Twig\Loader\FilesystemLoader('view');

$twig = new \Twig\Environment($loader);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('index.html.twig');

echo $template->render();
?>