<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION["status"] != "1") {

    header("location: ../index.php");
  
    exit;
}

if (isset($_SESSION["message"])) {
    unset($_SESSION["message"]);
}


require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\Notification;
use Azhar\Elms\LeaveRequests;

$database = new Database();
$db = $database->getConnection();
$notification = new Notification($db);
$leave_request = new LeaveRequests($db);

if (isset($_POST['btnupload']) && isset($_FILES['uploadedFile'])) {
    $filename = $_FILES['uploadedFile']['name'];
    $filesize =$_FILES['uploadedFile']['size'];
    $filetmp =$_FILES['uploadedFile']['tmp_name'];
    $filetype=$_FILES['uploadedFile']['type'];
    $filestore="../public/images/uploadMedicalDocument/".$filename;
    $id = $_SESSION['id'];
    // echo $id;
    $requestid = base64_decode($_GET["id"]);
    // echo $filename;
    // echo $requestid;
    // die();
    move_uploaded_file($filetmp, $filestore);

    $photo = $notification->funcInsertPhoto($filename, $requestid);
    $updateNotification= $notification->updateNotification($requestid);
    $updateViewButton = $notification->updateViewButton($requestid);
    // $_SESSION["message"] = "file uploaded sucessfully";
   
    if ($photo) {
        $_SESSION["message"] = "File Uploaded Sucessfully";
    } else {
        $_SESSION["message"] = "Some Error Occur";
    }
}


$id = $_SESSION['id'];
    // echo $id."<br>";


$requestid = base64_decode($_GET["id"]);
// echo $requestid;
$dateDetail = $leave_request->dateDetail($requestid);
// echo"<pre>";
// print_r($dateDetail);
include "displayNotification.php";
$filter  = new \Twig\TwigFilter('base64_encode', function ($string) {
    return base64_encode($string);
});
$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('user/uploadDocument.html.twig');

echo $template->render(['dateDetail' => $dateDetail, 'notificationNumber' => $notificationNumber , 'displayData' => $displayData , 'sizeOfdisplay' => sizeof($displayData)]);


?>