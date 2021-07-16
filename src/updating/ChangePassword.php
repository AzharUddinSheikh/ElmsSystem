<?php

namespace Azhar\ELMS\Updating;

class ChangePassword
{
    public static function changePass($id, $pass, $db)
    {
        $sql = "UPDATE users SET password = '$pass' WHERE id = '$id'";

        $db->query($sql);

        echo "password changed successfully";
    } 
}


?>