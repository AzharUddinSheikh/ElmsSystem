<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {

    header("location: ../index.php");
  
    exit;
}

include '_db.php';

InActivity::inActive($_SESSION["last_login_timestamp"]);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Welcome ELMS</title>
  </head>
  <body>
  <a class="btn btn-primary" href="../partials/logout.php">Logout</a>
  <a class="btn btn-warning" href="admin.php">Admin</a>  
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
                <td>'.$_SESSION["fullname"].'</td>
            </tr>
            <tr>
                <td>EmpID</td>
                <td>'.$_SESSION["emp_id"].'</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>'.$_SESSION["email"].'</td>
            </tr>
          </table>
          <h2 class="my-5 text-center"> OTHER DETAILS </h2>
          <table class="table table-striped table-dark">
              <tr>
                  <td>Birthday</td>
                  <td>'.$_SESSION["uservalue"].'</td>
              </tr>
              <tr>
                  <td>Number</td>
                  <td>'.$_SESSION["uservalue"].'</td>
              </tr>
            </table>
        </div>
        
        </div>';
        ?>
<!-- modal start  -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Change Password
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
          
    <script>
      $(document).ready(function() {
          $('#pass').blur(function() {
              var pass = $(this).val();
              if(pass == '' || pass.length <= 4) {
                $('#available').html('<span class="text-danger">Should Not Be Empty and Atleast 5 character</span>');
                $('.hide').hide();
              } else { 
                $('#available').html('<span class="text-success">Password Is Valid</span>');
                $('.hide').show();
                }
          });
          
          $("#submit").click(function() {
                var pass = $("#myForm :input").serializeArray();
                $.post( $("#myForm").attr("action"), pass, function(info) {
                    alert(info);
                });
            });
        
        $("#myForm").submit(function () {
                $("#myForm")[0].reset();
                return false;

        });
      })
    </script>
  </body>
</html>
