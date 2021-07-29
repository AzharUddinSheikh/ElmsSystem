<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {

    header("location: index.php");
  
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Inserting\AddLeave;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

if(isset($_SESSION["message"])){
  unset($_SESSION["message"]);
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $reason = $_POST["textarea"];
    $date1 = $_POST["dob"];
    $date2 = $_POST["dob1"];

    $database = new Database();
    $db = $database->getConnection();
    $leave = new AddLeave($db, $_SESSION["id"]);
    $result = $leave->appLeave($reason, $date1, $date2);

    if ($result) {
      $_SESSION["message"] = "Leave Has Been Applied";
    }
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

$template = $twig->load('applyleave.php');

echo $template->render();

?>