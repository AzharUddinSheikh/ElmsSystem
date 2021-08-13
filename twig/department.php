<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {

    header("location: ../index.php");

    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Department;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

$database = new Database();
$db = $database->getConnection();

$department = new Department($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $department->update($_POST["departEdit"], $_POST["departid"]);

    $_SESSION["message"] = "DEPARTMENT HAS BEEN UPDATED";
}

if(isset($_GET["delete"])){

    $department->delete($_GET["delete"]);

    $_SESSION["message"] = "DEPARTMENT HAS BEEN DELETED";
}

$result = $department->showList();

$department = array();
while ($row = $result->fetch_assoc()){
    array_push($department, $row);
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$function = new \Twig\TwigFunction('getUrl', function() {
    return basename($_SERVER['PHP_SELF']);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/department/index.html.twig');

echo $template->render(['departments' => $department, 'count' => sizeof($department)]);