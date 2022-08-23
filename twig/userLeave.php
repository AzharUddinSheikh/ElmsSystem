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

use Azhar\Elms\Database;
use Azhar\Elms\LeaveRequests;
use Azhar\Elms\LeaveDetails;
use Azhar\Elms\Users;

$database = new Database();
$db = $database->getConnection();

$leave_detail = new LeaveDetails($db);
$leave_request = new LeaveRequests($db);
$users = new Users($db);

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $reason = $_POST["textarea"];
    $date1 = $_POST["dob"];
    $date2 = $_POST["dob1"];
    $typeleave= $_POST['leavetype'];
    $id = $_SESSION["id"];
    $paidLeave = 2;
    $startdate = strtotime($date1);
    $enddate = strtotime($date2);
    $diff = $enddate - $startdate;
    $days=  abs(round($diff / 86400 )+1);
    $list = $users->getUserWithDept($id);
    $cLeave = $list[10];
    $mLeave = $list[11];
    $pLeave = $list[12];
    $leave_request->applyLeave($reason, $date1, $date2, $_SESSION["id"], $typeleave,$paidLeave);
    $leave_detail->createLeaveStatus($date1, $date2, $_SESSION["id"]);
    $_SESSION["message"] = "Leave Has Been Applied";
    
}
$id = base64_decode($_GET["id"]);
$result = $leave_request->showUserLeave($id);
$list = $users->getUserWithDept($id);
$history = array();
while($row = $result->fetch_assoc()) {
    array_push($history, $row);
}
$cyear = date("Y");
$date = date('Y-m-d');

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$function = new \Twig\TwigFunction('getNoOfDays', function($start, $end) {
    $days = abs(strtotime($start)-strtotime($end))/86400 +1;
    return ($days);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('user/userLeave.html.twig');

echo $template->render(['userleave' => $history, 'size' => sizeof($history), 'details'=>$list , 'cdate' =>$date ]);

?>