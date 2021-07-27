<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
  
    exit;
}


require_once 'vendor/autoload.php';

use Azhar\Elms\Updating\ApproveReject;
use Azhar\Elms\Getting\GetLeave;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Inactivity;

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);

if(isset($_GET["leave"])){
    
    $view_id  = base64_decode($_GET['leave']);
}

if(isset($_GET['approve'])) {
  
    $id = base64_decode($_GET['approve']);
    
    $apply_reject->approve($id);
}

if(isset($_GET['reject'])) {
    
    $id = base64_decode($_GET['reject']);
    
    $apply_reject->reject($id);
}

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$user_leave = new GetLeave($db);
            
$result = $user_leave->userLeave($view_id);

$leaves = array();
while($row = $result->fetch_assoc()) {
    array_push($leaves, $row);
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

$loader = new \Twig\Loader\FilesystemLoader('view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);
$twig->addFunction($function1);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('leaveDetail.php');

echo $template->render(['userleaves' => $leaves, 'size' => sizeof($leaves)]);
?>
