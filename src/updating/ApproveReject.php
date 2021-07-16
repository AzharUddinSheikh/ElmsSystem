<?php

namespace Azhar\ELMS\Updating;

class ApproveReject
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function approve($id)
    {
        $sql =  "UPDATE leave_requests SET status = 1 WHERE id = $id";
    
        mysqli_query($this->conn, $sql);
    }

    public function reject($id)
    {
        $sql =  "UPDATE leave_requests SET status = 2 WHERE id = $id";
    
        mysqli_query($this->conn, $sql);
    }
}

?>