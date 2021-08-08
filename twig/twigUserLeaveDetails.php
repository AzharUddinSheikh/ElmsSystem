<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Getting\DetailEmp;
use Azhar\Elms\Updating\EditEmp;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();


if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

$common = new DetailEmp($db);
            
$result = $common->showemp();

$details = array();

while($row = $result->fetch_assoc()) {
    array_push($details, $row);
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

$template = $twig->load('userLeaveDetails.html.twig');

echo $template->render(['employees' => $details, 'size' => sizeof($details)]);
