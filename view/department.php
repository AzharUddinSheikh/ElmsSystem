<?php 

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Login;
use Azhar\Elms\Department;
use Azhar\Elms\Users;
use Azhar\Elms\LeaveRequests;
use Azhar\Elms\LeaveDetails;

$database = new Database();
$db = $database->getConnection();

$department = new Department($db);
$users = new Users($db);
$login = new Login($db);
$leave_request = new LeaveRequests($db);
$leave_detail = new LeaveDetails($db);

if(isset($_POST["dep_name"])) {

    echo $department->isExists($_POST["dep_name"]);
}

if(isset($_POST["user_email"])) {

    echo $users->checkUserExistence($_POST["user_email"]);
}

if(isset($_POST["dname"])) {

    $department->create($_POST["dname"]);

    echo "data successfully inserted";
}

if(isset($_POST["newpass"]) && isset($_POST["oldpass"])) {

    session_start();

    if ($login->checkPassword($_SESSION["id"], $_POST["oldpass"])){

        $pass = password_hash($_POST["newpass"], PASSWORD_DEFAULT);

        $users->updatePassword($_SESSION["id"], $pass);

    } else {

        echo "CURRENT PASSWORD DOESNOT MATCH";
    }
}

if (isset($_POST["email"])){

    $result = $users->getUserStatus($_POST["email"]);

    if ($result == "0") {

        echo "Unable To Logged In Please Check The Email For Logged In";

    } elseif ($result == "2") {

        echo "User Is Blocked Contact Admin";
    }
}

if(isset($_POST["approve"]) && isset($_POST["ids"])){

    $ids = base64_decode($_POST["ids"]);
    
    $total_leave = $leave_request->totalLeaveRequested($ids);

    $id = base64_decode($_POST["approve"]);

    $leaves_approved = $leave_request->getApprovedLeave($id);

    $result = $leaves_approved + $total_leave;

    echo $result;
}

if(isset($_POST["approveS"])){

    $id = base64_decode($_POST["approveS"]);
    
    $result = $leave_detail->maxLeave($id);

    echo $result;
}

if (isset($_POST["leave_id"])){

    $result = $leave_request->gettingDate($_POST["leave_id"]);

    echo json_encode($result);
}
?>