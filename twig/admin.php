<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\LeaveDetails;
use Azhar\Elms\LeaveRequests;

$database = new Database();
$db = $database->getConnection();

$leave_detail = new LeaveDetails($db);
$leave_request = new LeaveRequests($db);


if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}


if(isset($_GET['approve'])) {

    $id = base64_decode($_GET['approve']);
  
    $leave_detail->approveUserRequest($id);

    $_SESSION["message"] = "USER LEAVES APPROVED";
    
}

if(isset($_POST["submit"])) {

    $dob = $_POST["dob"];
    $dob1 = $_POST["dob1"];

    $id = base64_decode($_POST["userleaveid"]);

    $leave_detail->updateLeave($dob, $dob1, $id);

    $_SESSION["message"] = "USER LEAVE UPDATED";
}

if(isset($_POST["submit1"])){

    $reason = $_POST["reason"];

    $id = base64_decode($_POST["rejectid"]);

    $leave_detail->rejectUserRequest($id, $reason);

    $_SESSION["message"] = "USER LEAVES REJECTED";
}

$result = $leave_request->pendingLeaveRequest();

$leaves = array();
while($row = $result->fetch_assoc()) {
    array_push($leaves, $row);
}

$loader = new \Twig\Loader\FilesystemLoader('../view');

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$function = new \Twig\TwigFunction('getNoOfDays', function($start, $end) {
    $days = abs(strtotime($start)-strtotime($end))/86400 +1;
    return ($days);
});

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/index.html.twig');

echo $template->render(['leaves' => $leaves, 'count' => sizeof($leaves)]);

?>