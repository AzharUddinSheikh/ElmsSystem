<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {

    header("location: ../index.php");

    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\GeneralSetting;

if(isset($_SESSION["message"])){
    unset($_SESSION["message"]);
}

$database = new Database();
$db = $database->getConnection();

$General_Setting = new GeneralSetting($db);

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

// if($_SERVER['REQUEST_METHOD'] == "POST") {
//    $enyear = $_POST['enyear'];
//    $read = $General_Setting->readGeneral();
// //    echo "<pre>";
// //    print_r($read);
// //    die();
//    $enterYear = $General_Setting->enterYear($enyear,$cyear);
// //    $updateYear = $General_Setting->updateLeave($enyear,$cyear);
//    $_SESSION["message"] = "Updated";

   
//    $history = array();
// while($row = $read->fetch_assoc()) {
//     array_push($history, $row);
// }
//    $new = [];
//    echo "<pre>";
//    foreach ($history as $key=> $data) {
//         print_r( $data);
//         $new[$key][$data['key']] = $data['value'];
//    }
//    echo "<pre>";
//    print_r($new);
//    die();

// }
$cYear = date("Y");
if($_SERVER['REQUEST_METHOD'] == "POST") {
       $enterYear = $_POST['enyear'];
       $enterYear = $General_Setting->enYear($enterYear);
       $yearlyLeave = $General_Setting->yearlyLeave($cYear,$enterYear);
       $_SESSION["message"] = "Updated";


}

$readAll = $General_Setting->readAll();
// echo "<pre>";
// print_r($readAll) ;
// $c = sizeof($readAll);
// echo $c;
// die();
$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);
$twig->addFilter($filter);
$twig->addGlobal('session', $_SESSION);


$template = $twig->load('admin/generalsetting/index.html.twig');

echo $template->render(['readAll' => $readAll ,'size' => sizeof($readAll) ,'cyear' => $cYear]);