<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {

    header("location: index.php");
  
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\LeaveRequests;
use Azhar\Elms\LeaveDetails;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$leave_request = new LeaveRequests($db);
$leave_detail = new LeaveDetails($db);

if(isset($_SESSION["message"])){
  unset($_SESSION["message"]);
}

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $reason = $_POST["textarea"];
    $date1 = $_POST["dob"];
    $date2 = $_POST["dob1"];

    $leave_request->applyLeave($reason, $date1, $date2, $_SESSION["id"]);
    $leave_detail->createLeaveDetail($date1, $date2, $_SESSION["id"]);

    $_SESSION["message"] = "Leave Has Been Applied";
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

$template = $twig->load('user/applyleave.html.twig');

echo $template->render();

?>