<?php

namespace Azhar\ELMS\Common;

class InActivity
{
    public static function inActive($session_time) 
    {
        if ((time() - $session_time) > 1800) {
            header("location: ../partials/logout.php");
        } else {
            $session_time = time();
        }
    }
}

?>