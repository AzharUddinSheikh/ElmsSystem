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
    
    if (Email::sendEmail($email, base64_encode(GetEmpId::getId($db, $email)))) {

        $_SESSION["flash"] = "Reset Link Has Been Sent To Registered Email";

    } 

    header("location: ../index.php");
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$template = $twig->load('forgot.html.twig');

echo $template->render();
?>
