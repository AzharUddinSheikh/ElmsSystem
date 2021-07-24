<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {

    header("location: ../index.php");
  
    exit;
}

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Inserting\AddLeave;

Inactivity::inActive($_SESSION["last_login_timestamp"]);

if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $reason = $_POST["textarea"];
    $date1 = $_POST["dob"];
    $date2 = $_POST["dob1"];

    $database = new Database();
    $db = $database->getConnection();
    $leave = new AddLeave($db, $_SESSION["id"]);
    $leave->appLeave($reason, $date1, $date2);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../partials/header.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <style>
      .error {
        color:red;
      }
      .valid {
        color:green;
      }
    </style>
    <title>Leave Elms</title>
</head>

<body class="bg-secondary">
  <?php include '../partials/navigation.php'; ?>
  <div class="w-50 mx-auto my-5 ">
      <h2 class="mb-5">Fill Out The Form For Applying Leave</h2>
      <form action="" method="POST" name="applyLeave">
        <div class="form-group mb-5">
            <label for="textarea">Reason</label>
            <textarea class="form-control" id="textarea" name="textarea"></textarea>
        </div>
        <div class="mb-5">
          <label for="dob" class="form-label">Start Date</label>
          <input type="text" class="date form-control" name="dob" id="dob" onkeypress="return false">
        </div>
        <div class="mb-5">
          <label for="dob1" class="form-label">End Date</label>
          <input type="text" class="date form-control" name="dob1" id="dob1" onkeypress="return false">
        </div>
        <div class="col-md-12 text-center">
          <span class="submit">
            <button type="submit" class="btn btn-primary">Apply</button>
          </span>
          <button type="reset" class="btn btn-primary">Clear</button>
        </div>
      </form>
    </div>
    <script src="../public/javascript/applyleave.js"></script>
</body>
</html>