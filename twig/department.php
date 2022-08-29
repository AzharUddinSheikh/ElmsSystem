<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {

    header("location: ../index.php");

    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\Department;

if (isset($_SESSION["message"])) {
    unset($_SESSION["message"]);
}

$database = new Database();
$db = $database->getConnection();

$department = new Department($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $department->update($_POST["departEdit"], $_POST["departid"]);

    $_SESSION["message"] = "DEPARTMENT HAS BEEN UPDATED";
}

if (isset($_GET["delete"])) {

    $department->delete($_GET["delete"]);

    $_SESSION["message"] = "DEPARTMENT HAS BEEN DELETED";
}

$result = $department->showList();

$department = array();
while ($row = $result->fetch_assoc()) {
    array_push($department, $row);
}

$filter  = new \Twig\TwigFilter('base64_encode', function ($string) {
    return base64_encode($string);
});

$function  = new \Twig\TwigFilter('getNoOfEmp', function ($id) {
    $database = new Database();
    $db = $database->getConnection();

    $department = new Department($db);
    $result = $department->noOfUserInDept($id);

    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $count++;
    }

    return $count;
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFilter($function);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/department/index.html.twig');

echo $template->render(['departments' => $department, 'count' => sizeof($department)]);