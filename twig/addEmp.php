<?php

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Email;
use Azhar\Elms\Users;
use Azhar\Elms\UserDetails;
use Azhar\Elms\Department;

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['user'] != '1' || $_SESSION['status'] != '1') {
    
    header("location: index.php");

    exit;
}

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$departments = new Department($db);
$users = new Users($db);
$user_details = new UserDetails($db);

if(isset($_SESSION["added"])){
    unset($_SESSION["added"]);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $dob   = $_POST['dob'];
    $number= $_POST['number'];
    $empid = $_POST['empid']; 
    $dname = $_POST['dname'];
    $utype = $_POST['utype'];

    Email::sendEmail($email, base64_encode($empid));

    $users->createUser($empid, $fname, $lname, $email, $dname, $utype);

    $user_details->createUserDetails($number, $dob, $email);

    $_SESSION["added"] = "EMPLOYEE ADDED AND NEED TO CHECK EMAIL FOR FURTHER PROCEDURE";
}

$result = $departments->showList();

$department = array();
while ($row = $result->fetch_assoc()){
    array_push($department, $row);
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

$template = $twig->load('admin/employee/addEmp.html.twig');

echo $template->render(['details' => $department, 'size' => sizeof($department)]);
?>