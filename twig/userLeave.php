<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION["status"] != "1") {

    header("location: ../index.php");
  
    exit;
}

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

if(base64_decode($_GET["id"]) != $_SESSION["id"] && $_SESSION["user"] != "1"){

    echo "User Request Rejected";

    die();
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\InActivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\LeaveRequests;
use Azhar\Elms\LeaveDetails;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$leave_detail = new LeaveDetails($db);
$leave_request = new LeaveRequests($db);

if(isset($_GET["cancel"])) {

  $id = base64_decode($_GET['cancel']);

  $leave_request->deleteUserRequest($id);

  $_SESSION["message"] = "DELETED SELECTED LEAVE PROPOSAL";
}

$id = base64_decode($_GET["id"]);

$result = $leave_request->showUserLeave($id);

$history = array();
while($row = $result->fetch_assoc()) {
    array_push($history, $row);
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$function = new \Twig\TwigFunction('getUrl', function() {
    return basename($_SERVER['PHP_SELF']);
});

$function1 = new \Twig\TwigFunction('diffTime', function($date) {
    $today_date = strtotime(date('Y-m-d'));
    $start_date = strtotime($date);
    return ($start_date - $today_date);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);
$twig->addFunction($function1);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('user/userLeave.html.twig');

echo $template->render(['userleave' => $history, 'size' => sizeof($history)]);

?>