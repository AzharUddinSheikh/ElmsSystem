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
use Azhar\Elms\Getting\GetLeave;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

if(isset($_GET['approve'])) {

    $id = base64_decode($_GET['approve']);
  
    $apply_reject->approve($id);

    $_SESSION["message"] = "USER LEAVES APPROVED";
    
}

if(isset($_GET['reject'])) {
  
    $id = base64_decode($_GET['reject']);
    
    $apply_reject->reject($id);

    $_SESSION["message"] = "USER LEAVES REJECTED";
}

$comm = new GetLeave($db);
                    
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

$template = $twig->load('pendingLeave.php');

echo $template->render(['leaves' => $leaves, 'count' => sizeof($leaves)]);

?>