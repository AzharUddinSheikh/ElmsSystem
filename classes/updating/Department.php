<?php

namespace Azhar\ELMS\Updating;

class Department
{
    public static function updateDepart($db, $name, $encoded)
    {
        $id = base64_decode($encoded);

        $sql = "UPDATE departments SET name = '$name' WHERE id = '$id'";
    
        $db->query($sql);
    }

    public static function delDepartment($db, $encoded)
    {
        $id = base64_decode($encoded);

        $sql = "DELETE FROM departments WHERE id = '$id'";

        $db->query($sql);
    }
}

?>