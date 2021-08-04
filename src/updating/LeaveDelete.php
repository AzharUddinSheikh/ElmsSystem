<?php

namespace Azhar\ELMS\Updating;

class LeaveDelete
{
    public static function deleteRequest($db, $id)
    {
        $sql = "DELETE FROM leave_requests WHERE id = $id";

        mysqli_query($db, $sql);
    }

    public static function updateLeave($db, $id, $dob, $dob1)
    {
        $sql = "UPDATE leave_requests SET start_date = '$dob', end_date = '$dob1' WHERE id = '$id'";
        
        $db->query($sql);
    }
}

?>