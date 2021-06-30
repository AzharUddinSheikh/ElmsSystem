<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    
  header("location: ../index.php");
  
  exit;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

    <a href="addEmp.php">Add Employee</a>
    <a href="../partials/logout.php">Logout</a>

        <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      ADD DEPARTMENT
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Department Name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           
            <form id="dept-form" autocomplete="off" method="POST">
                <div class="mb-2">
                    <input name="dname" id="dname" type="text" class="form-control" placeholder="Enter The Department Name">
                </div>
                <div class="mb-1"><span id="available"></span></div>
                <div class="hide"><button type="button" id="submit" class="btn btn-primary">ADD</button></div>
            </form>

        </div>
    </div>
    </div>
    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#dname').blur(function() {
                var dname = $(this).val();

                $.ajax({
                    url:'department.php',
                    method:"POST",
                    data:{dep_name:dname},
                    success:function(data)
                    {   
                        if(data == 0)
                        {
                            $('#available').html('<span class="text-danger">Department Not Available</span>');
                            $('.hide').show();
                        }
                        else 
                        {
                            $('#available').html('<span class="text-success">Department Available Cant Add</span>');
                            $('.hide').hide();
                        }
                    }
                })
            })
        })
    </script>

</body>
</html>