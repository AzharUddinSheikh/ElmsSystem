<?php

namespace Azhar\ELMS\Getting;

class GetDepartment
{
    public static function getDept($db)
    {
        $sql = "SELECT * FROM departments";
        
        $result = $db->query($sql);

        return $result;
    }
}

?>