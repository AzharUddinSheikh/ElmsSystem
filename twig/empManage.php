<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\Users;

$database = new Database();
$db = $database->getConnection();

$users = new Users($db);

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

if(isset($_GET['block'])) {
    
    $id = base64_decode($_GET['block']);
    
    $users->blockUser($id);

    $_SESSION["message"] = "USER IS BLOCKED";
}

if(isset($_GET['unblock'])) {
    
    $id = base64_decode($_GET['unblock']);
    
    $users->unblockUser($id);

    $_SESSION["message"] = "USER IS UNBLOCKED";
}

$result = $users->showUserList();

$details = array();
while($row = $result->fetch_assoc()) {
    array_push($details, $row);
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/employee/index.html.twig');

echo $template->render(['employees' => $details, 'size' => sizeof($details)]);
