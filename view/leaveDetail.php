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
    <a class="btn btn-primary" href="admin.php">Cancel</a>
    <h1 class="text-center mt-3">Leave History Of A User</h1>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3">
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
                        if ($row["status"] == "1") {
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