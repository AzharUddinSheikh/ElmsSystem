<?php

namespace Azhar\ELMS;
use \DateTime;

class LeaveRequests
{
    private $conn;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function totalLeaveRequested($id)
    {
        $sql = "SELECT * FROM leave_requests WHERE id = '$id'";

        $result = $this->conn->query($sql);

        while ($row = $result->fetch_assoc()){
            $begin = new DateTime($row["start_date"]);
            $end = new DateTime($row["end_date"]);
        }
        $count = 0;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $count++;
        }
        return $count;
    }

    public function getApprovedLeave($id)
    {
        $sql = "SELECT ls.from_date, ls.to_date FROM users u JOIN leave_requests lr ON u.id = lr.user_id JOIN leave_status ls ON ls.requests_id = lr.id WHERE u.emp_id = $id AND ls.status = 1 AND YEAR(ls.from_date) = YEAR(CURDATE())";

        $result = $this->conn->query($sql);

        $count = 0;
        while ($row = $result->fetch_assoc()){
            $begin = new DateTime($row["from_date"]);
            $end = new DateTime($row["to_date"]);

            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $count++;
            }
        }
        return $count;
    }


    public function applyLeave($reason, $date1, $date2, $id)
    {
        $new_date1 = date("Y-m-d", strtotime($date1));
        $new_date2 = date("Y-m-d", strtotime($date2));

        $sql = "INSERT INTO leave_requests (user_id, reason, start_date, end_date) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("isss", $id, $reason,  $new_date1, $new_date2);

        $stmt->execute();
    }

    public function pendingLeaveRequest()
    {
        $sql = "SELECT u.id as user_id, lr.id, u.emp_id, lr.reason, lr.start_date, lr.end_date, u.first_name, u.last_name FROM users u JOIN leave_requests lr ON u.id = lr.user_id WHERE lr.start_date > CURDATE() AND lr.status = 0 ORDER BY lr.id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function showUserLeave($id)
    {
        $sql = "SELECT lr.id, lr.start_date as 'start' , lr.end_date as 'end', lr.reason as excuse, ls.status, ls.reason, ls.from_date as 'from', ls.to_date as 'to' FROM leave_requests lr JOIN leave_status ls ON lr.id = ls.requests_id WHERE lr.user_id = '$id' ORDER BY lr.id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function gettingDate($encoded)
    {
        $id = base64_decode($encoded);

        $sql = "SELECT * FROM leave_requests WHERE id = '$id'";

        $result = $this->conn->query($sql);

        $dataarray = array();
        while ($row = $result->fetch_assoc()){
            array_push($dataarray, $row["start_date"], $row["end_date"]);
        }

        return $dataarray;
    }
}

?>