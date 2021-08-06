<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {

    header("location: ../index.php");

    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Inserting\AddLeave;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $pass = $_POST["pass1"];

    $_SESSION["message"] = "Password Changed Successfully";
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('changePassword.php');

echo $template->render();

?>