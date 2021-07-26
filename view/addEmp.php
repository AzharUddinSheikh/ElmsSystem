<?php

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Common\Email;
use Azhar\Elms\Inserting\Employee;
use Azhar\Elms\Getting\GetDepartment;

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['user'] != '1' || $_SESSION['status'] != '1') {
    
    header("location: ../index.php");

    exit;
}

Inactivity::inActive($_SESSION["last_login_timestamp"]);

$database = new Database();
$db = $database->getConnection();
  
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $dob   = $_POST['dob'];
    $number= $_POST['number'];
    $empid = $_POST['empid']; 
    $dname = $_POST['dname'];
    $utype = $_POST['utype'];
    
    $common = (new Employee($db, $email));

    $common->checkUser();
    Email::sendEmail($email, base64_encode($empid));
    $common->createUser($empid, $fname, $lname, $dname, $utype);
    $common->createDetail($number, $dob);

}

?>

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
     <title>Document</title>
</head>

<body class="bg-secondary">
    <?php include '../partials/navigation.php'; ?>
    <div class="w-50 mx-auto">
      <h2>Fill Out The Detail With Valid Email Address</h2>
      <form action="" method="POST" name='addemp' id='addemp'>
        <div class="mb-3">
          <label for="fname" class="form-label">First Name</label>
          <input type="text" class="form-control" name="fname" id="fname">
        </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lname" id="lname">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input id="uEmail" type="text" class="form-control" name="email" id="email">
          <span id="available"></span>
        </div>
        <div class="mb-3">
          <label for="dob" class="form-label">Date Of Birth</label>
          <input type="text" class="form-control" name="dob" id="dob">
          <span id="dobID"></span>
        </div>
        <div class="mb-3">
          <label for="number" class="form-label">Phone Number</label>
          <input type="number" class="form-control" name="number" id="number">
        </div>
        <div class="mb-3">
          <label for="empid" class="form-label">Emp Id</label>
          <input type="number" class="form-control" name="empid" id="empid">
        </div>
        <div class="mb-4 mt-4 text-center ">
        <?php
          $result = GetDepartment::getDept($db);
          echo
          '<select class="col px-md-4 py-md-1" name="dname" id="dname">
            <option value="" disabled selected>Select Department</option>';
            while ($row = $result->fetch_assoc()){
              echo '<option value='.$row["id"].'>'.$row["name"].'</option>';
            }
            echo '</select>';
          ?>
          <select class="col px-md-4 py-md-1" name="utype" id="utype">
            <option value="" disabled selected>Select User Type</option>
            <option value=0>User</option>
            <option value=1>Admin</option>
          </select>
        </div>
        
        <div class="col-md-12 text-center">
          <span class="submit">
            <button id="submit" type="submit" class="btn btn-primary">Submit</button>
          </span>
          <button type="reset" class="btn btn-primary">Clear</button>
        </div>
      </form>
    </div>

</body>
</html>
<script src="../public/javascript/addEmp.js"></script>