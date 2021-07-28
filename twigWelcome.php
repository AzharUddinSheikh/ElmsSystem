<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION["status"] != "1") {

    header("location: index.php");
  
    exit;
}

require_once 'vendor/autoload.php';

use Azhar\Elms\Common\InActivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\LeaveDelete;
use Azhar\Elms\Getting\GetLeave;
use Azhar\Elms\Getting\EditDetail;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

if(isset($_GET["cancel"])) {

  $id = base64_decode($_GET['cancel']);

  LeaveDelete::deleteRequest($db, $id);
}

$detail = EditDetail::detailEdit($db, $_SESSION["emp_id"]);

$user_leave = new GetLeave($db);
// today today missing in a code 
$result = $user_leave->userLeave($_SESSION["id"]);

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

$loader = new \Twig\Loader\FilesystemLoader('view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addFunction($function);
$twig->addFunction($function1);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('welcome.php');

echo $template->render(['details' => $detail, 'userleave' => $history, 'size' => sizeof($history)]);

?>