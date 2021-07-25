<?php

namespace Azhar\ELMS\Getting;

class DetailEmp
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    public function showemp() 
    {
    
        $sql = "SELECT * FROM departments JOIN users WHERE users.department_id = departments.id AND users.status != 0";
    
        $result = $this->conn->query($sql);
    
        return $result;
    }

    public static function getDecrypt($encoded)
    {
        $decoded = "";
        for( $i = 0; $i < strlen($encoded); $i++ ) {
            $b = ord($encoded[$i]);
            $a = $b ^ 123; 
            $decoded .= chr($a);
        }
        return $decoded;
    }
}

?>