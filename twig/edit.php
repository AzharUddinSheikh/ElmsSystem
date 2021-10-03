<?php

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\UserDetails;
use Azhar\Elms\Users;

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {
    
    header("location: ../index.php");

    exit;
  }

$id = base64_decode($_GET["id"]);

if(!isset($_GET["id"]) || (($id != $_SESSION["emp_id"])) && $_SESSION["user"] != "1" ){
    
    echo "User Request Rejected";
    
    die();
}

$database = new Database();
$db = $database->getConnection();

$users = new Users($db);
$user_details = new UserDetails($db);

$detail_emp = $user_details->gettingUserDetail($id);

if(isset($_SESSION["update"])){
    unset($_SESSION["update"]);
}

if(isset($_POST['submit'])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $number = $_POST["number"];
    
    if((!empty($_FILES['image']))){
        $img = $_FILES["image"]['name'];
    } 

    if ($_FILES["image"]['name'] == ""){
        $img = $detail_emp[6];
    } 

    $users->updateUser($fname, $lname, $email, $img, $id);
    $user_details->updateUserDetails($dob, $number, $id);
    $users->saveProfileImage($img);
    
    $_SESSION["update"] = "PROFILE HAS BEEN UPDATED";
}

$emp_detail = $user_details->gettingUserDetail($id);

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);
$twig->addGlobal('session', $_SESSION);

$template = $twig->load('editprofile.html.twig');

echo $template->render(['userdetail' => $emp_detail]);

?>