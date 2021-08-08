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

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

if(isset($_GET['Sreject'])) {
  
    $id = base64_decode($_GET['Sreject']);

    $id1 = base64_decode($_GET['userdetails']);
    
    $apply_reject->rejectEachLeave($id, $id1);

    $_SESSION["message"] = "SELECTED DATE REJECTED";
}

if(isset($_GET['Sapprove'])) {
  
    $id = base64_decode($_GET['Sapprove']);

    $id1 = base64_decode($_GET['userdetails']);
    
    $apply_reject->approveEachLeave($id, $id1);

    $_SESSION["message"] = "SELECTED DATE APPROVED";
}

if(isset($_GET["userdetails"])){

    $id = base64_decode($_GET["userdetails"]);

    $sql = "SELECT * FROM leave_details WHERE leave_id = '$id'";

    $result = $db->query($sql);

    $leave_detailed = array();
    while ($row = $result->fetch_assoc()){
        array_push($leave_detailed, $row);
    }
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

$template = $twig->load('checkStatus.php');

echo $template->render(['leavedetail' => $leave_detailed, 'num' => sizeof($leave_detailed)]);
?>