<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION["status"] != "1") {

    header("location: ../index.php");
  
    exit;
}

if (isset($_SESSION["message"])) {
    unset($_SESSION["message"]);
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\Notification;
use Azhar\Elms\LeaveRequests;

$database = new Database();
$db = $database->getConnection();
$notification = new Notification($db);
$leave_request = new LeaveRequests($db);

$requestid = base64_decode($_GET["id"]);
$viewImage = $notification->viewImage($requestid);

[$showFirstName, $showLastName ]= $leave_request->viewName($requestid);
$filter  = new \Twig\TwigFilter('base64_encode', function ($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/employee/viewDocument.html.twig');

echo $template->render(['viewImage'=> $viewImage , 'showFirstName' => $showFirstName , 'showLastName' => $showLastName]);

?>