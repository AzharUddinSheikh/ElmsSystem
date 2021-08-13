<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\LeaveDetails;
use Azhar\Elms\LeaveRequests;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

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

if(isset($_GET['reject'])) {
  
    $id = base64_decode($_GET['reject']);
    
    $leave_detail->rejectUserRequest($id);

    $_SESSION["message"] = "USER LEAVES REJECTED";
}

$result = $leave_request->pendingLeaveRequest();

$leaves = array();
while($row = $result->fetch_assoc()) {
    array_push($leaves, $row);
}

$function1 = new \Twig\TwigFunction('diffTime', function($date) {
    $today_date = strtotime(date('Y-m-d'));
    $start_date = strtotime($date);
    return ($start_date - $today_date);
});


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
$twig->addFunction($function1);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('admin/leave/pendingLeave.html.twig');

echo $template->render(['leaves' => $leaves, 'count' => sizeof($leaves)]);

?>