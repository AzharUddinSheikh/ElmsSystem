<?php 

include '_db.php';

class GetEmpId{
    private $conn;
    
    public static function getId($db, $email){

        $sql = "SELECT emp_id FROM users WHERE email = '$email'";
        
        $result = $db->query($sql);
       
        while($row = $result->fetch_assoc()) {
                
            return $row["emp_id"];

          }
    }
}

class SetStatus{
    private $conn;
    
    public static function setToZero($db, $email){

        $sql = "UPDATE users SET status = 0 WHERE email = '$email'";
        
        $db->query($sql);
    }
}

if ($_SERVER['REQUEST_METHOD']=="POST") {

    $email = $_POST['email'];
   
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    $common = (new Employee($db, $email));
    
    SetStatus::setToZero($db, $email);

    Email::sendEmail($email, GetEmpId::getId($db, $email));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>forgot password</title>
</head>
<body>
    <div class="w-50 mx-auto text-center">
        <h1 class="mt-5">Forgot Password</h1>
        <form class="w-30 my-5" method="POST">
            <div class="mb-3">
                <input name="email" type="email" class="form-control" id="email" placeholder="Email Address">
            </div>
            <div class="mb-3" id="available"></div>
            <div class="submit">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#email').blur(function() {
                var email = $(this).val();

                if(email == '') {
                    $('#available').html('<span class="text-danger">Email Field Should Not Empty</span>');
               
                    $('.submit').hide();
                
                } else { 
                    
                    $('.submit').show();
                
                    $.ajax({
                        url:'department.php',
                        method:"POST",
                        data:{user_email:email},
                        success:function(data)
                        {   
                            if(data == 0)
                            {
                                $('#available').html('<span class="text-danger">Email Not Exists</span>');
                                $('.submit').hide();
                            }
                            else 
                            {
                                $('#available').html('<span class="text-success">Email Found Click For Reset Link</span>');
                                $('.submit').show();
                            }
                        }
                    })
                }
            })
        })
    </script>

</body>
</html>
                