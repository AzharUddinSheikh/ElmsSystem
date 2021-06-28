<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="8; url='http://localhost/elms/src/admin.php'" />
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