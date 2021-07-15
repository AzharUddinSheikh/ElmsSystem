<?php

namespace Azhar\ELMS\Updating;

class BlockUnBlock
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function block($id)
    {
        $sql =  "UPDATE users SET status = 2 WHERE id = $id";
    
        mysqli_query($this->conn, $sql);
    }

    public function unBlock($id)
    {
        $sql =  "UPDATE users SET status = 1 WHERE id = $id";
    
        mysqli_query($this->conn, $sql);
    }
}

?>