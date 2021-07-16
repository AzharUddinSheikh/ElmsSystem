<?php

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Inactivity;
use Azhar\Elms\Common\Database;
use Azhar\Elms\Getting\EditDetail;
use Azhar\Elms\Updating\EditEmp;

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['status'] != '1') {
    
    header("location: ../index.php");

    exit;
}

if(!isset($_GET["id"]) || (($_GET["id"] != $_SESSION["id"])) && $_SESSION["user"] != "1" ){
    
    echo'<script>alert("User Request Rejected")</script>';

    die();
}

$database = new Database();
$db = $database->getConnection();


Inactivity::inActive($_SESSION["last_login_timestamp"]);

if(isset($_POST['submit'])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $number = $_POST["number"];
    
    if((!empty($_FILES['image']))){
        $img = $_FILES["image"]['name'];
      } 

    if ($_FILES["image"]['name'] == ""){
        $img = "default.jpg";
    } 
      
    $emp_edit = new EditEmp($db, $_GET["id"]);
    $emp_edit->updateUser($fname, $lname, $email, $img);
    $emp_edit->updateUserDetail($dob, $number);
    $emp_edit->img_folder($img);
    
    echo '<script>alert("Profile Has been Updated")</script>';
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
    
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" type="text/javascript"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>

    <script src="../public/javascript/edit.js" type="text/javascript"></script>
    
    <style>
      .error {
        color:red;
      }
      .valid {
        color:green;
      }
      </style>

<title>Edit Profile</title>
</head>
<body class="bg-secondary">
  <div class="w-50 mx-auto">
    <h2 class="text-center">EDIT PROFILE</h2>
    <form action="" method="POST" name='edit' id='edit' enctype="multipart/form-data">
    <?php 
      $detail_emp = EditDetail::detailEdit($db, $_GET["id"]);
    ?>
    <div class="mb-3">
      <label for="fname" class="form-label">First Name</label>
      <input type="text" class="form-control" name="fname" id="fname" value=<?php echo $detail_emp[0] ;?>>
        </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lname" id="lname" value=<?php echo $detail_emp[1] ;?>>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input id="uEmail" type="email" class="form-control" name="email" id="email" value=<?php echo $detail_emp[2]; ?>>
          <span id="available"></span>
        </div>
        <div class="mb-3">
            <div class="mb-3">
              <label for="number" class="form-label">Phone Number</label>
              <input type="number" class="form-control" name="number" id="number" value=<?php echo $detail_emp[4] ;?>>
        </div>
        <div>
            <label for="dob" class="form-label">Date Of Birth</label>
            <input type="date" class="form-control" name="dob" id="dob" onkeypress="return false" value=<?php echo $detail_emp[3] ;?>>
            <span id="dobID"></span>
        </div>
        <div class="custom-file my-5">
            <input type="file" class="custom-file-input" id="image" name="image">
            <label class="custom-file-label" for="photo">Profile Photo</label>
        </div>
        <div class="col-md-12 my-3 text-center">
          <span class="submit px-3">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </span>
          <a class="btn btn-primary" href="admin.php">Cancel</a>
        </div>
      </form>
    </div>

</body>
</html>