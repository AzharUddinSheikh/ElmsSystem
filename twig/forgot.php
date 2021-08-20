<?php 

require_once '../vendor/autoload.php';

session_start();

use Azhar\Elms\Email;
use Azhar\Elms\Database;
use Azhar\Elms\Users;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];

    $database = new Database();
    $db = $database->getConnection();

    $users = new Users($db);

    $users->resetStatus($email);
    
    if (Email::sendEmail($email, base64_encode($users->getUserId($email)))) {

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

$template = $twig->load('partials/forgot.html.twig');

echo $template->render();
?>
