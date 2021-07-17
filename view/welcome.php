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

  $id = $_GET['cancel'];

  LeaveDelete::deleteRequest($db, $id);
}

$detail = EditDetail::detailEdit($db, $_SESSION["id"]);

?>

<!doctype html>
<html lang="en">
  <head>
    <?php include '../partials/header.php'; ?>
    <title>Welcome ELMS</title>
  </head>
  <body>
  <a class="btn btn-primary" href="../partials/logout.php">Logout</a>
  <?php 
    if ($_SESSION["user"] == "1") {
      echo '<a class="btn btn-warning" href="admin.php">Admin</a>';
    }
  ?>
  <a class="btn btn-secondary" href="editprofile.php?id=<?php echo $_SESSION["id"]; ?>">Edit Profile</a>
  <a class="btn btn-secondary" href="applyleave.php">Apply Leave</a>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Change Password
  </button>
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
            $user_leave = new GetLeave($db, $_SESSION["id"]);

            $today_date = strtotime(date('Y-m-d'));

            if($user_leave->userLeave()) {
              
              $count = 0;

              while($row = $user_leave->result1->fetch_assoc()) {
                
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
                        echo "<button class='btn btn-info' disabled>No Action</button>";
                      } elseif ($row["status"] == 0) {
                        echo "<button id='$row[id]' class='cancel btn btn-secondary'>Cancel</button>";
                      }
                    echo
                    '</td>
                    </tr>';
              }
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
                        <input name="pass" id="pass" type="password" class="form-control" placeholder="Enter The Password">
                    </div>
                    <div class="mb-1"><span id="available"></span></div>
                    <div class="hide"><button id="submit" class="btn btn-primary">Change</button></div>
                </form>

            </div>
        </div>
    </div>
  <!-- modal end -->           
    <script src="../public/javascript/welcome.js"></script>
  </body>
</html>
