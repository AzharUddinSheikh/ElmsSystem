<?php

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\Department;

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['user'] != '1' || $_SESSION['status'] != '1') {
    
    header("location: index.php");

    exit;
}

if (!isset($_GET["id"])) {
    $_SESSION["message"] = "REQUEST REJECTED WRONG URL";
    header("location : index.php");
}

$database = new Database();
$db = $database->getConnection();

$id = base64_decode($_GET["id"]);

$result = Department::noOfUserInDept($db, $id);

$list = array();
while ($row = $result->fetch_assoc()) {
    array_push($list, $row);
}

$filter  = new \Twig\TwigFilter('base64_encode', function ($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/department/empList.html.twig');

echo $template->render(['rows' => $list, 'count' => sizeof($list)]);
?>