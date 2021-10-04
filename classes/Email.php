<?php

namespace Azhar\ELMS;

class Email
{
	public static function sendEmail(string $email, string $empid) : bool
	{
        $to = $email;
        $subject = "ELMS Employee Email Verification";
        $message = '<a href=http://localhost/elms/twig/verify.php?empid='.$empid.'>Verified Your Account</a>';
        $headers = 'From: azharsheikh760@gmail.com'       . "\r\n" .
                    'Reply-To: azharsheikh760@gmail.com' . "\r\n" .
                    'Content-type: text/html; charset=utf-8' . "\r\n".
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        return true;
        }
    }
?>