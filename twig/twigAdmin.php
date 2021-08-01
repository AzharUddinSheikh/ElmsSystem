<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\ApproveReject;
use Azhar\Elms\Updating\BlockUnBlock;
use Azhar\Elms\Getting\DetailEmp;
use Azhar\Elms\Getting\GetLeave;
use Azhar\Elms\Updating\LeaveDelete;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);
$block_unblock = new BlockUnBlock($db);

if(isset($_SESSION["leave"])){
    unset($_SESSION["leave"]);
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $dob = $_POST["dob"];
    $dob1 = $_POST["dob1"];
    $id = base64_decode($_POST["userleaveid"]);
    
    LeaveDelete::updateLeave($db, $id, $dob, $dob1);

    $_SESSION["leave"] = "USER LEAVE UPDATED";
}

if(isset($_GET['approve'])) {

    $id = base64_decode($_GET['approve']);
  
    $apply_reject->approve($id);

    $_SESSION["leave"] = "USER LEAVE APPROVED";
    
}

if(isset($_GET['reject'])) {
  
    $id = base64_decode($_GET['reject']);
    
    $apply_reject->reject($id);

    $_SESSION["leave"] = "USER LEAVE REJECTED";
}

if(isset($_GET['block'])) {
    
    $id = base64_decode($_GET['block']);
    
    $block_unblock->block($id);

    $_SESSION["leave"] = "USER IS BLOCKED";
}

if(isset($_GET['unblock'])) {
    
    $id = base64_decode($_GET['unblock']);
    
    $block_unblock->unBlock($id);

    $_SESSION["leave"] = "USER IS UNBLOCKED";
}

if(isset($_GET["cancel"])) {

    $id = base64_decode($_GET['cancel']);
  
    LeaveDelete::deleteRequest($db, $id);

    $_SESSION["leave"] = "USER LEAVE DELETED";
}

$common = new DetailEmp($db);
            
$result = $common->showemp();

$details = array();

while($row = $result->fetch_assoc()) {
    array_push($details, $row);
}

$comm = new GetLeave($db);
                    
$today_date = strtotime(date('Y-m-d'));

$result = $comm->leaveRequest();

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

$template = $twig->load('admin.php');

echo $template->render(['employees' => $details, 'size' => sizeof($details), 'leaves' => $leaves, 'count' => sizeof($leaves)]);

?>