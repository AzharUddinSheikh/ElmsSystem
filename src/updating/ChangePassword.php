<?php

namespace Azhar\ELMS\Updating;

class ChangePassword
{
    public static function changePass($email, $pass, $db)
    {
        $sql = "UPDATE users SET password = '$pass' WHERE email = '$email'";

        $db->query($sql);

        echo "password changed successfully";
    } 
}


?>