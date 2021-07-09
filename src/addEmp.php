<?php

include '../classes/_common.php';
include '../classes/_inserting.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['user'] != '1') {
    
    header("location: ../index.php");

    exit;
}

InActivity::inActive($_SESSION["last_login_timestamp"]);
  
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $dob   = $_POST['dob'];
    $number= $_POST['number'];
    $empid = $_POST['empid']; 
    $dname = $_POST['dname'];
    $utype = $_POST['utype'];

    $database = new Database();
    $db = $database->getConnection();
    
    $common = (new Employee($db, $email));

    $common->checkUser();
    Email::sendEmail($email, $empid);
    $common->createUser($empid, $fname, $lname, $dname, $utype);
    $common->createDetail($number, $dob);

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

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
          <input type="date" class="form-control" name="dob" id="dob" onkeypress="return false">
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
          <select class="col px-md-4 py-md-1" name="dname" id="dname">
            <option value="" disabled selected>Select Department</option>
            <option value=1>Php</option>
            <option value=2>Python</option>
          </select>
          <select class="col px-md-4 py-md-1" name="utype" id="utype">
            <option value="" disabled selected>Select User Type</option>
            <option value=0>User</option>
            <option value=1>Admin</option>
          </select>
        </div>
        
        <div class="col-md-12 text-center">
          <span class="submit">
            <button type="submit" class="btn btn-primary">Submit</button>
          </span>
          <a class="btn btn-primary" href="admin.php">Cancel</a>
          <button type="reset" class="btn btn-primary">Clear</button>
        </div>
      </form>
    </div>

</body>
</html>
<script src="../public/javascript/addEmp.js"></script>
    

