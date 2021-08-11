<?php

namespace Azhar\ELMS\Updating;

class LeaveDelete
{
    public static function deleteRequest($db, $id)
    {
        $sql = "DELETE FROM leave_requests WHERE id = $id";

        mysqli_query($db, $sql);
    }
}

?>