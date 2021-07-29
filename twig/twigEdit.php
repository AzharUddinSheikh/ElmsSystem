<?php

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Getting\EditDetail;
use Azhar\Elms\Updating\EditEmp;

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

$detail_emp = EditDetail::detailEdit($db, $id);

Inactivity::inActive($_SESSION["last_login_timestamp"]);

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
      
    $emp_edit = new EditEmp($db, $id);
    $emp_edit->updateUser($fname, $lname, $email, $img);
    $emp_edit->updateUserDetail($dob, $number);
    $emp_edit->img_folder($img);
    
    $_SESSION["update"] = "PROFILE HAS BEEN UPDATED";
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$function = new \Twig\TwigFunction('getUrl', function() {
    return basename($_SERVER['PHP_SELF']);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFunction($function);
$twig->addFilter($filter);
$twig->addGlobal('session', $_SESSION);

$template = $twig->load('editprofile.php');

echo $template->render(['userdetail' => $detail_emp]);

?>