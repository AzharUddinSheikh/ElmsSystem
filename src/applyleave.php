<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {

    header("location: ../index.php");
  
    exit;
}

include '_db.php';

InActivity::inActive($_SESSION["last_login_timestamp"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Leave Elms</title>
</head>
<body class="bg-secondary">
    
<div class="w-50 mx-auto my-5 ">
      <h2 class="mb-5">Fill Out The Form For Applying Leave</h2>
      <form action="" method="POST">
        <div class="form-group mb-5">
            <label for="exampleFormControlTextarea1">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-5">
          <label for="dob" class="form-label">Start Date</label>
          <input type="date" class="form-control" name="dob" id="dob">
        </div>
        <div class="mb-5">
          <label for="dob1" class="form-label">End Date</label>
          <input type="date" class="form-control" name="dob1" id="dob1">
        </div>
        <div class="col-md-12 text-center">
          <span class="submit">
            <button type="submit" class="btn btn-primary">Apply</button>
          </span>
          <a class="btn btn-primary" href="admin.php">Cancel</a>
          <button type="reset" class="btn btn-primary">Clear</button>
        </div>
      </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>