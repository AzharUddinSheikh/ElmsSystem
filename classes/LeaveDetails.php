<?php

namespace Azhar\ELMS;
use \DateTime;

class LeaveDetails
{
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function specificLeaveDetail($leave_id)
    {
        $sql = "SELECT * FROM leave_details WHERE leave_id = '$leave_id'";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function createLeaveDetail($date1, $date2, $id)
    {
        $result = $this->conn->query("SELECT id FROM leave_requests WHERE user_id = $id ORDER BY id DESC LIMIT 1");
        $last_id = (int)$result->fetch_assoc()["id"];
        $begin = new DateTime($date1);
        $end   = new DateTime($date2);
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $leave = $i->format("Y-m-d");
            $stmt = $this->conn->prepare("INSERT INTO leave_details (leave_id, leave_applied) VALUES (?, ?)");
            $stmt->bind_param("is", $last_id, $leave);
            $stmt->execute();
        }
    }

    public function maxLeave($id)
    {
        $extract = "SELECT * FROM leave_requests lr JOIN leave_details ld ON lr.id = ld.leave_id WHERE lr.id = '$id'";

        $rows = $this->conn->query($extract);

        $user_id = $rows->fetch_assoc()["user_id"];

        $sql = "SELECT * FROM leave_details ld JOIN leave_requests lr ON ld.leave_id = lr.id WHERE lr.user_id = '$user_id' and ld.status = 1 and year(curdate()) = year(ld.leave_applied)";

        $result = mysqli_query($this->conn, $sql);

        $row = mysqli_num_rows($result);

        return $row;
    }

    public function approveUserRequest($id)
    {
        $sql =  "UPDATE leave_details SET status = 1 WHERE leave_id = $id";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id";
        
        mysqli_query($this->conn, $sql);

        mysqli_query($this->conn, $sql1);
    }

    public function rejectUserRequest($id)
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