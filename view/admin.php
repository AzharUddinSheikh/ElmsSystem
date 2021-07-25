<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1' || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");
    
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\ApproveReject;
use Azhar\Elms\Updating\BlockUnBlock;
use Azhar\Elms\Getting\DetailEmp;
use Azhar\Elms\Getting\GetLeave;
use Azhar\Elms\Updating\LeaveDelete;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);
$block_unblock = new BlockUnBlock($db);

if(isset($_GET['approve'])) {
  

    $id = DetailEmp::getDecrypt($_GET['approve']);
  
    $apply_reject->approve($id);
}

if(isset($_GET['reject'])) {
  
    $id = DetailEmp::getDecrypt($_GET['reject']);
    
    $apply_reject->reject($id);
}

if(isset($_GET['block'])) {
    
    $id = DetailEmp::getDecrypt($_GET['block']);
    
    $block_unblock->block($id);
}

if(isset($_GET['unblock'])) {
    
    $id = DetailEmp::getDecrypt($_GET['unblock']);
    
    $block_unblock->unBlock($id);
}

if(isset($_GET["cancel"])) {

    $id = DetailEmp::getDecrypt($_GET['cancel']);
  
    LeaveDelete::deleteRequest($db, $id);
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../partials/header.php'; ?>
    <title>Document</title>
</head>
<body>
    <?php include '../partials/navigation.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <span id="result"></span>
    
    <!-- table leave  -->
    <h1 class="text-center">EMPLOYEE LEAVE PROPOSAL REJECT OR APPROVED</h1>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Emp-ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">StartDate</th>
                    <th scope="col">EndDate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $comm = new GetLeave($db);
                    
                    $today_date = strtotime(date('Y-m-d'));
                    
                    $result = $comm->leaveRequest();
                        
                        $count = 0;
                        
                        while($row = $result->fetch_assoc()) {
                            
                            $count++;
                            echo
                            '<tr>
                            <td>'.$count.'</td>
                            <td>'.$row["emp_id"].'</td>
                            <td>'.$row["first_name"]." ".$row["last_name"].'</td>
                            <td>'.$row["start_date"].'</td>
                            <td>'.$row["end_date"].'</td>';

                            $start_date = strtotime($row["start_date"]);

                            if (($start_date - $today_date) <= 0){
                                echo '<td><button id='.$row["id"].' class="cancel btn btn-secondary">Cancel</button></td>';
                            } else {
                                echo '<td><button id='.$row["id"].' class="approve btn btn-success">Approve</button>  <button id='.$row["id"].' class="reject btn btn-danger">Reject</button></td>';
                            }
                            echo 
                            '</tr>';
                        }
                ?>
            </tbody>
        </table>
    </div>
    <!-- end table leave -->

    <!-- table -->
    <div class="container mt-5">
        <h1 class="text-center">EMPLOYEE DETAIL CAN BE EDITED OR BLOCKED </h1>
    </div>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Emp-ID</th>
                    <th scope="col">First-Name</th>
                    <th scope="col">Last-Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Department-Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
      <?php
        $common = new DetailEmp($db);
            
        $result = $common->showemp();
        
        $count = 0;

        while($row = $result->fetch_assoc()) {
            
            $count++;
        
            echo "<tr>
            <th scope='row'>". $count."</th>
            <td>".$row["emp_id"]."</td>
            <td>".$row["first_name"]."</td>
            <td>".$row["last_name"]."</td> 
            <td>".$row["email"]."</td> 
            <td>".$row["name"]."</td>
            <td>";
            if($_SESSION["emp_id"] === $row["emp_id"]){
                echo "<button class='block btn btn-danger' disabled>BLOCK</button>";
            } else {
                if ($row["status"] == "1") {
                    echo "<button id='$row[id]' class='block btn btn-danger'>BLOCK</button>";
                } elseif ($row["status"] == "2") {
                    echo "<button id='$row[id]' class='unblock btn btn-warning'>UNBLOCK</button>";
                }
            }
             echo " <button id='$row[id]' type='button' class='edit btn btn-warning'>EDIT</button>  <button id='$row[id]' type='button' class='view btn btn-secondary'>View</button>
            </tr>";
        }
?>
        </tbody>
        </table>
        
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal">Department Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <form id="myForm" action="department.php" autocomplete="off" method="POST">
                    <div class="mb-2">
                        <input name="dname" id="dname" type="text" class="form-control" placeholder="Enter The Department Name">
                    </div>
                    <div class="mb-1"><span id="available"></span></div>
                    <div class="hide"><button id="submit" class="btn btn-primary">ADD</button></div>
                </form>

            </div>
        </div>
    </div>
</div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../public/javascript/admin.js"></script>
</body>
</html>