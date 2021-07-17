<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
  
    exit;
}


require_once '../vendor/autoload.php';

use Azhar\Elms\Updating\ApproveReject;
use Azhar\Elms\Getting\GetLeave;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Inactivity;

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);

if(isset($_GET["leave"])){
    $view_id  = $_GET["leave"];
}

if(isset($_GET['approve'])) {
  
    $id = $_GET['approve'];
    
    $apply_reject->approve($id);
}

if(isset($_GET['reject'])) {
    
    $id = $_GET['reject'];
    
    $apply_reject->reject($id);
}

Inactivity::inActive($_SESSION["last_login_timestamp"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Leave</title>
        <!-- Bootstrap CSS -->
    <?php include '../partials/header.php'; ?>       
</head>

<body>
    <?php include '../partials/navigation.php'; ?>  
    <h1 class="text-center mt-3">Leave History Of A User</h1>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Added-On</th>
                    <th scope="col">StartDate</th>
                    <th scope="col">EndDate</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
            $user_leave = new GetLeave($db, $view_id);
            
            $today_date = strtotime(date('Y-m-d'));
            
            if($user_leave->userLeave()) {

                $count = 0;
                
                while($row = $user_leave->result1->fetch_assoc()) {
                    
                    $count++;
                    
                    echo
                    '<tr>
                        <td>'.$count.'</td>
                        <td>'.$row["reason"].'</td>
                        <td>'.$row["added_on"].'</td>
                        <td>'.$row["start_date"].'</td>
                        <td>'.$row["end_date"].'</td>
                        <td>';
                        if($row["status"] == 0){
                            echo "PENDING";
                        } elseif ($row["status"] == 1){
                            echo "APPROVED";
                        } else {
                            echo "REJECTED";
                        }
                        echo
                        '</td>
                        <td>';
                        $start_date = strtotime($row["start_date"]);
                        if (($start_date - $today_date) <= 0){
                            echo '<button class="btn btn-info" disabled>N/A</button>';
                        } elseif ($row["status"] == "1") {
                            echo "<button id='$row[id]' name='$row[user_id]' class='reject btn btn-danger'>Reject</button>";
                        } elseif ($row["status"] == "2") {
                            echo "<button id='$row[id]' name='$row[user_id]' class='approve btn btn-success'>Approve</button>";
                        }
            
                }
            }
            ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="../public/javascript/leaveDetail.js"></script>
</body>
</html>