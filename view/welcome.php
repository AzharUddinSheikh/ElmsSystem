<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION["status"] != "1") {

    header("location: ../index.php");
  
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\InActivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\LeaveDelete;
use Azhar\Elms\Getting\GetLeave;
use Azhar\Elms\Getting\EditDetail;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();

if(isset($_GET["cancel"])) {

  $id = base64_decode($_GET['cancel']);

  LeaveDelete::deleteRequest($db, $id);
}

$detail = EditDetail::detailEdit($db, $_SESSION["emp_id"]);

?>

<!doctype html>
<html lang="en">
  <head>
    <?php include '../partials/header.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <title>Welcome ELMS</title>
  <style>
    .error {
      color : red;
    }
  </style>
  </head>
  <body>
  <?php include '../partials/navigation.php'; ?>
  
  <div class="text-center">
    <img style="width:150px;height:150px;border-radius: 50%;" src=<?php echo "../public/images/".$detail[6]; ?>>
  </div>
  <div class="container">
    <h2 class="text-center my-5" >
    <?php 
          if ($_SESSION["user"] == '1') {
            echo "ADMIN ";
          } else {
            echo "USER ";
          }
    echo  'DETAIL</h2>
          <table class="table table-striped table-dark">
            <tr>
                <td>Name</td>
                <td>'.$detail[0]." ".$detail[1].'</td>
            </tr>
            <tr>
                <td>EmpID</td>
                <td>'.$detail[5].'</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>'.$detail[2].'</td>
            </tr>
          </table>
          <h2 class="my-5 text-center"> OTHER DETAILS </h2>
          <table class="table table-striped table-dark">
              <tr>
                  <td>Birthday</td>
                  <td>'.$detail[3].'</td>
              </tr>
              <tr>
                  <td>Number</td>
                  <td>'.$detail[4].'</td>
              </tr>
            </table>
        </div>';
      ?>
    <h2 class="text-center my-5">LEAVE HISTORY OF THE USER</h2>
    <div class="container mt-5 mb-5">
      <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
              <tr>
                <th scope="col">Sno</th>
                <th scope="col">Applied On</th>
                <th scope="col">StartDate</th>
                <th scope="col">EndDate</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
            $user_leave = new GetLeave($db);

            $today_date = strtotime(date('Y-m-d'));

            $result = $user_leave->userLeave($_SESSION["id"]);
              
              $count = 0;

              while($row = $result->fetch_assoc()) {
                
                $count++;
                
                echo
                    '<tr>
                    <td>'.$count.'</td>
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
                    if (($start_date - $today_date) <= 0) {
                        echo "<button class='btn btn-info' disabled>N/A</button>";
                      } elseif ($row["status"] == 0) {
                        echo "<button id='".base64_encode($row['id'])."' class='cancel btn btn-secondary'>Cancel</button>";
                      }
                    echo
                    '</td>
                    </tr>';
              }
            ?>
            </tbody>
      </table>
    </div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <form class="text-center" id="myForm" action="department.php" autocomplete="off" method="POST">
                  <div class="mb-2">
                      <input name="oldpass" id="oldpass" type="password" class="form-control" placeholder="Enter The Old Password">
                  </div>
                  <div class="mb-2">
                      <input name="pass" id="pass" type="password" class="form-control" placeholder="Enter The Password">
                  </div>
                    <div class="mb-1"><span id="available"></span></div>
                    <div class="hide"><button id="submit" class="btn btn-primary">Change</button></div>
                </form>

            </div>
        </div>
    </div>
  <!-- modal end -->           
</body>
</html>
<script src="../public/javascript/welcome.js"></script>
