<?php

namespace Azhar\ELMS\Updating;

class SetStatus
{
    private $conn;
     
    public static function setToZero($db, $email)
    {
        $sql = "UPDATE users SET status = 0 WHERE email = '$email'";
        
        $db->query($sql);
    }
}

?>