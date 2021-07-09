<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['user'] != '1') {

    header("location: ../index.php");
  
    exit;
}

include '../classes/_common.php';
include '../classes/_getting.php';
include '../classes/_updating.php';

InActivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

$apply_reject = new ApproveReject($db);
$block_unblock = new BlockUnBlock($db);

if(isset($_GET['approve'])) {
  
    $id = $_GET['approve'];
  
    $apply_reject->approve($id);
}

if(isset($_GET['reject'])) {
  
    $id = $_GET['reject'];

    $apply_reject->reject($id);
}

if(isset($_GET['block'])) {
  
    $id = $_GET['block'];
    
    $block_unblock->block($id);
}

if(isset($_GET['unblock'])) {
    
    $id = $_GET['unblock'];
    
    $block_unblock->unBlock($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
      </script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
      <script>
        $(document).ready( function () {
            $('table').DataTable();
        });
    </script>
</head>
<body>
    <a class="btn btn-warning" href="welcome.php">Home</a>
   
    <a class="btn btn-secondary" href="../partials/logout.php">Logout</a>
    <span id="result"></span>
    
    <!-- table leave  -->
    <h1 class="text-center">EMPLOYEE LEAVE PROPOSAL REJECT OR APPROVED</h1>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Emp-ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">StartDate</th>
                    <th scope="col">EndDate</th>
                    <th scope="col">Action</th>
                </tr>
                <?php 
                    $comm = new GetLeave($db, $_SESSION["id"]);
                    
                    if($comm->leaveRequest()) {
                        
                        $count = 0;
                        
                        while($row = $comm->result->fetch_assoc()) {
                            $count++;
                            
                            echo
                            '<tr>
                            <td>'.$count.'</td>
                            <td>'.$row["emp_id"].'</td>
                            <td>'.$row["first_name"]." ".$row["last_name"].'</td>
                            <td>'.$row["start_date"].'</td>
                            <td>'.$row["end_date"].'</td>
                            <td><button id='.$row["id"].' class="approve btn btn-success">Approve</button>  <button id='.$row["id"].' class="reject btn btn-danger">Reject</button></td>
                            </tr>';
                        }
                    }
                ?>
            </thead>
        </table>
    </div>
    <!-- end table leave -->

    <!-- table -->
    <div class="container mt-5">
        <h1 class="text-center">EMPLOYEE DETAIL CAN BE EDITED OR BLOCKED </h1>
    </div>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3">
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
            
        if ($common->showemp()) {
        
        $count = 0;

        while($row = $common->result->fetch_assoc()) {
            
            $count++;
        
            echo "<tr>
            <th scope='row'>". $count."</th>
            <td>".$row["emp_id"]."</td>
            <td>".$row["first_name"]."</td>
            <td>".$row["last_name"]."</td> 
            <td>".$row["email"]."</td> 
            <td>".$row["name"]."</td>
            <td>";
            if ($row["status"] == "1") {
                echo "<button id='$row[id]' class='block btn btn-danger'>BLOCK</button>";
            } elseif ($row["status"] == "2") {
                echo "<button id='$row[id]' class='unblock btn btn-warning'>UNBLOCK</button>";
            }
             echo " <button type='button' class='btn btn-warning'>EDIT</button>
            </tr>";
        }
        
        }

        ?>
        </tbody>
        </table>
    <!-- endtable -->
    
        <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      ADD DEPARTMENT
    </button>
    <a class="btn btn-primary" href="addEmp.php">Add Employee</a>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Department Name</h5>
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
    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../public/javascript/admin.js"></script>
</body>
</html>