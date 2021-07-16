<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['user'] != '1' || $_SESSION['status'] != '1') {

  header("location: ../index.php");
  
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php';?>
    <meta http-equiv="refresh" content="8; url='http://localhost/elms/view/admin.php'" />
    <title>Thankyou Page</title>
</head>
<body>
    <h1>Email Has Been Sent To Register Email Address</h1>
    <h2 id="count">You ll be redirect to dashboard page in <div id="countdown"></div></h2>
    <p>Email Link Is Valid Only For 30 Min</p>

    <script>
        var timeleft = 6;
        var downloadTimer = setInterval(function(){
        if(timeleft <= 0){
            clearInterval(downloadTimer);
            document.getElementById("count").innerHTML = "Redirecting....";
        } else {
            document.getElementById("countdown").innerHTML = timeleft + " seconds";
        }
        timeleft -= 1;
        }, 1000);
    </script>
</body>
</html>