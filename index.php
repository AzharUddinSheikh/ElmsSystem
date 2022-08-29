<?php 
require_once 'vendor/autoload.php';

session_start();

if (isset($_SESSION["loggedin"])) {

    if ($_SESSION["user"] == "0"  && ($_SESSION["status"] == "1")) {

        header('location:twig/welcome.php');

    } elseif ($_SESSION["user"] == "1"  && ($_SESSION["status"] == "1")) { 

        header('location: twig/admin.php');

    }
} 

use Azhar\Elms\Database;
use Azhar\Elms\Users;
use Azhar\Elms\Notification;

$database = new Database();

$db = $database->getConnection();

$users = new Users($db);
$notification = new Notification($db);

if (isset($_SESSION["flash"])) {
    unset($_SESSION["flash"]);
}

if ($_SERVER['REQUEST_METHOD']=="POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $valid = $users->validUser($email);

    if (!$valid) {

        $_SESSION["flash"] = "USER NOT FOUND";

    } else {
      
        $actual_password = $valid["password"];
        $user_type = $valid["user_type"];

        $result = $users->validPass($password, $actual_password, $user_type, $valid);

        if (!$result) {

            $_SESSION["flash"] = "WRONG PASSWORD";
        } else {
            echo "<pre>";
            print_r($valid);
        }
    }
}




$loader = new \Twig\Loader\FilesystemLoader('view');

$twig = new \Twig\Environment($loader);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('index.html.twig');

echo $template->render();
?>