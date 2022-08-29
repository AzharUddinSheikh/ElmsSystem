<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {

    header("location: ../index.php");

    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;

$filter  = new \Twig\TwigFilter('base64_encode', function ($string) {
    return base64_encode($string);
});


include "displayNotification.php";
$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('changePassword.html.twig');

echo $template->render(['notificationNumber' => $notificationNumber , 'displayData' => $displayData , 'sizeOfdisplay' => sizeof($displayData)]);

?>