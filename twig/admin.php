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
    [$luserid,$days,$ltype]=$leave_detail->getNumOfLeaves($id);
    $updatePCMLeaveResult=$leave_detail->updatePCMLeave($luserid,$days,$ltype);
    $setPaid= $leave_request->setPaid($id);
    echo $id."<br>";
    echo $setPaid;
    echo $ltype;
    die();
    $leave_detail->approveUserRequest($id);
    $_SESSION["message"] = "USER LEAVES APPROVED";
    header("Location:http://localhost/ElmsSystem-sahil/twig/admin.php");
    
    
}

if(isset($_GET['nonPaidApprove'])) {

    $id = base64_decode($_GET['nonPaidApprove']);
  
    [$luserid,$days,$ltype]=$leave_detail->getNumOfLeaves($id);
    $updatePCMLeaveResult=$leave_detail->updatePCMLeave($luserid,$days,$ltype);
    $setNonPaid= $leave_request->setNonPaid($id);
    
    $leave_detail->approveUserRequest($id);
    $_SESSION["message"] = "USER NON PAID LEAVES APPROVED";
    header("Location:http://localhost/ElmsSystem-sahil/twig/admin.php");
    
    
}

if(isset($_POST["submit"])) {

    $dob = $_POST["dob"];
    $dob1 = $_POST["dob1"];

    $sdob = strtotime($dob);
    $edob1 = strtotime($dob1);
    $diff = $edob1 - $sdob;

    $id = base64_decode($_POST["userleaveid"]);
    $modifydays = abs(round($diff / 86400 )+1);
    [$mLType, $mUserId]= $leave_detail->modifydetails($id);
    $modifyUpdateLeave = $leave_detail->modifyUpdateLeave($modifydays,$mLType, $mUserId);
    
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

$function1 = new \Twig\TwigFunction('getUrl', function() {
    return basename($_SERVER['PHP_SELF']);
});


$cyear = date("Y");

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);
$twig->addFunction($function1);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/index.html.twig');

echo $template->render(['leaves' => $leaves, 'count' => sizeof($leaves), 'cyear' => $cyear]);
?>