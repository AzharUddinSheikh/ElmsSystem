<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {

  header("location: ../index.php");
  
  exit;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <title>Welcome ELMS</title>
  </head>
  <body>
    <div class="container">
        <h2 class='text-center my-5' >
        <?php 
          if ($_SESSION["user"] == '1') {
            echo "ADMIN ";
          } else {
            echo "USER ";
          }
        ?>DETAIL</h2>
          <table class="table table-striped table-dark">
              <?php
        
            echo '<tr>
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
                  <td>Phone Number</td>
                  <td>'.$_SESSION["uservalue"].'</td>
              </tr>
            </table>
        </div>';
?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
  </body>
</html>
            