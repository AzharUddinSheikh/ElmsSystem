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
        $message = "<a href=http://localhost/elms/twig/twigVerify.php?empid=$empid>Verified Your Account</a>";
        $headers = 'From: azharsheikh760@gmail.com'       . "\r\n" .
                    'Reply-To: azharsheikh760@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        return true;
        }
    }
?>