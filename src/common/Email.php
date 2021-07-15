<?php

namespace Azhar\ELMS\Common;

class Email
{
    private $email;
    private $empid;

    public static function sendEmail($email, $empid)
    {
        $to = $email;
        $subject = "ELMS Employee Email Verification";
        $message = "<a href=http://localhost/elms/partials/verify.php?empid=$empid>Verified Your Account</a>";
        $headers = 'From: azharsheikh760@gmail.com'       . "\r\n" .
                    'Reply-To: azharsheikh760@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        if (!mail($to, $subject, $message, $headers)) {

            die("mail has not been send to registered email, Registration Failed");
        }   
    }
}

?>