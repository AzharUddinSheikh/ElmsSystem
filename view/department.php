<?php 

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Login;
use Azhar\Elms\Inserting\Department;
use Azhar\Elms\Inserting\Employee;
use Azhar\Elms\Updating\ChangePassword;

$database = new Database();
$db = $database->getConnection();

$login = new Login($db);

if(isset($_POST["dep_name"])) {
   
    $depart = new Department($_POST["dep_name"], $db);
    
    echo $depart->checkDept();
}

if(isset($_POST["user_email"])) {

    $emp = new Employee($db, $_POST["user_email"]);
    
    echo $emp->checkUser();
}

if(isset($_POST["dname"])) {
    
    $dep = new Department($_POST["dname"], $db);

    $dep->create();
    
    echo "data successfully inserted";
}

if(isset($_POST["newpass"]) && isset($_POST["oldpass"])) {
    
    session_start();
    
    if ($login->checkPassword($_SESSION["id"], $_POST["oldpass"])){
        
        $pass = password_hash($_POST["newpass"], PASSWORD_DEFAULT);
        
        ChangePassword::changePass($_SESSION["id"], $pass, $db);
        
    } else {
        
        echo "CURRENT PASSWORD DOESNOT MATCH";
    }
}

if (isset($_POST["email"])){
    
    $emp = new Employee($db, $_POST["email"]);
    
    $result = $emp->userStatus();
    
    if ($result == "0") {

        echo "Unable To Logged In Please Check The Email For Logged In";
        
    } elseif ($result == "2") {
        
        echo "User Is Blocked Contact Admin";
    }
}
?>