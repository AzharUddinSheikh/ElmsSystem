<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION["status"] != "1" || $_SESSION["user"] != "0") {

    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$id = $_SESSION['id'];


$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addGlobal('session', $_SESSION);

$template = $twig->load('user/index.html.twig');

echo $template->render();
?>