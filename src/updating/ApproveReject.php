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
        $sql =  "UPDATE leave_details SET status = 1 WHERE leave_id = $id";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id";
        
        mysqli_query($this->conn, $sql);

        mysqli_query($this->conn, $sql1);
    }

    public function reject($id)
    {
        $sql =  "UPDATE leave_details SET status = 2 WHERE leave_id = $id";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id";
    
        mysqli_query($this->conn, $sql);

        mysqli_query($this->conn, $sql1);
    }

    public function rejectEachLeave($id, $id1)
    {
        $sql = "UPDATE leave_details SET status = 2 WHERE id = '$id'";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id1";

        mysqli_query($this->conn, $sql);

        mysqli_query($this->conn, $sql1);
    }

    public function approveEachLeave($id, $id1)
    {
        $sql = "UPDATE leave_details SET status = 1 WHERE id = '$id'";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id1";

        mysqli_query($this->conn, $sql);

        mysqli_query($this->conn, $sql1);
    }
}

?>