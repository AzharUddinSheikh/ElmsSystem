<?php

namespace Azhar\ELMS;

class LeaveDetails
{
    private $conn;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function specificLeaveDetail(int $leave_id) : object
    {
        $sql = "SELECT * FROM leave_details WHERE leave_id = '$leave_id'";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function createLeaveStatus(string $date1, string $date2, int $id) : void
    {
        $result = $this->conn->query("SELECT id FROM leave_requests WHERE user_id = '$id' ORDER BY id DESC LIMIT 1");

        $last_id = (int)$result->fetch_assoc()["id"];
        $time1 = strtotime($date1);
        if ($time1 === false) {
            throw new \Exception('Invalid date: ' . $date1);
        }
        $time2 = strtotime($date2);
        if ($time2 === false) {
            throw new \Exception('Invalid date: ' . $date2);
        }
        $start = date("Y-m-d", $time1);
        $end = date("Y-m-d", $time2);

        $sql = "INSERT INTO leave_status (requests_id, from_date, to_date) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("iss", $last_id, $start,  $end);

        $stmt->execute();
    }

    public function updateLeave(string $start, string $end, int $id) : void
    {
        $time1 = strtotime($start);
        if ($time1 === false) {
            throw new \Exception('Invalid date: ' . $start);
        }
        $time2 = strtotime($end);
        if ($time2 === false) {
            throw new \Exception('Invalid date: ' . $end);
        }
        $date1 = date("Y-m-d", $time1);
        $date2 = date("Y-m-d", $time2);
        $sql = "UPDATE leave_status SET from_date = '$date1', to_date = '$date2', status = 1 WHERE requests_id = '$id'";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id";

        $this->conn->query($sql);

        $this->conn->query($sql1);
    }

    public function maxLeave(int $id) : int
    {
        $extract = "SELECT * FROM leave_requests lr JOIN leave_details ld ON lr.id = ld.leave_id WHERE lr.id = '$id'";

        $rows = $this->conn->query($extract);

        $user_id = $rows->fetch_assoc()["user_id"];

        $sql = "SELECT * FROM leave_details ld JOIN leave_requests lr ON ld.leave_id = lr.id WHERE lr.user_id = '$user_id' and ld.status = 1 and year(curdate()) = year(ld.leave_applied)";

        $result = $this->conn->query($sql);

        $row = mysqli_num_rows($result);

        return $row;
    }

    public function approveUserRequest(int $id) : void
    {
        $sql =  "UPDATE leave_status SET status = 1 WHERE requests_id = $id";

        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id";
        
        mysqli_query($this->conn, $sql);

        mysqli_query($this->conn, $sql1);
    }

    public function rejectUserRequest(int $id, string $reason) : void
    {
        $sql =  "UPDATE leave_status SET status = 2, reason = '$reason' WHERE requests_id = $id";
        $sql1 = "UPDATE leave_requests SET status = 1 WHERE id = $id";
        mysqli_query($this->conn, $sql);
        mysqli_query($this->conn, $sql1);
    }

    public function approvedLeave() : object
    {
        $sql = "SELECT ls.from_date as 'from', ls.to_date as 'to', lr.reason AS excuse, ls.reason, lr.start_date, lr.end_date, lr.added_on, lr.user_id, lr.id, u.first_name, u.last_name FROM leave_requests lr JOIN leave_status ls ON lr.id = ls.requests_id JOIN users u ON u.id = lr.user_id WHERE ls.status = 1 ORDER BY lr.id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function rejectedLeave() : object
    {
        $sql = "SELECT lr.reason AS excuse, ls.reason, lr.start_date, lr.end_date, lr.added_on, lr.user_id, lr.id, u.first_name, u.last_name FROM leave_requests lr JOIN leave_status ls ON lr.id = ls.requests_id JOIN users u ON u.id = lr.user_id WHERE ls.status = 2 ORDER BY lr.id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getNumOfLeaves($id) 
    {
    
        $qry = "SELECT * FROM leave_requests where id = $id ";
        $result = $this->conn->query($qry);
        $show = $result->fetch_assoc();
        $luserid = $show['user_id'];
        $startdate = strtotime($show['start_date']);
        $enddate = strtotime($show['end_date']);
        $diff = $enddate - $startdate;
        $days=  abs(round($diff / 86400)+1);
        $ltype = $show['user_typeleave'];
        return [$luserid,$days,$ltype];
    }   

    public function updatePCMLeave($luserid,$days,$ltype) 
    {
        $qry1 = "SELECT * FROM users WHERE id = $luserid " ;
        $result = $this->conn->query($qry1);
        $show = $result->fetch_assoc();
        $originalPLeave = $show['privilege_leave'];
        $originalMLeave = $show['medical_leave'];
        $originalCLeave = $show['casual_leave'];
        $avaliablePLeave = $originalPLeave - $days;
        $avaliableMLeave = $originalMLeave - $days;
        $avaliableCLeave = $originalCLeave - $days;
        if ($ltype == 2 ) {
            $qry2 = "UPDATE users SET privilege_leave= $avaliablePLeave WHERE id = $luserid  ";
            $result2 = $this->conn->query($qry2);
            return true;
        } else if ($ltype == 1) {
 
            $qry3 = "UPDATE users SET medical_leave= $avaliableMLeave WHERE id = $luserid  ";
            $result3 = $this->conn->query($qry3);
            return true;
        } else {

            $qry4 = "UPDATE users SET casual_leave= $avaliableCLeave WHERE id = $luserid  ";
            $result4 = $this->conn->query($qry4);
            return true;
        }
    }

    public function modifydetails($id)
    {
        $qry = "SELECT * FROM leave_requests WHERE id =  $id";
        $result = $this->conn->query($qry);
        $show = $result->fetch_assoc();
        $mLType = $show['user_typeleave'];
        $mUserId = $show['user_id'];
        return [$mLType, $mUserId];
    } 

    public function modifyUpdateLeave($modifydays,$mLType,$mUserId)
    {
        $qry = "SELECT * FROM users WHERE id = $mUserId";
        $result = $this->conn->query($qry);
        $show = $result->fetch_assoc    ();  
        $originalPLeave = $show['privilege_leave'];
        $originalMLeave = $show['medical_leave'];
        $originalCLeave = $show['casual_leave'];
        $avaliablePLeave = $originalPLeave - $modifydays;
        $avaliableMLeave = $originalMLeave - $modifydays;
        $avaliableCLeave = $originalCLeave - $modifydays;
        if ($mLType == 2 ) {
            $qry2 = "UPDATE users SET privilege_leave= $avaliablePLeave WHERE id = $mUserId  ";
            $result2 = $this->conn->query($qry2);
            return true;
        } else if ($mLType == 1) {
            $qry3 = "UPDATE users SET medical_leave= $avaliableMLeave WHERE id = $mUserId  ";
            $result3 = $this->conn->query($qry3);
            return true;
        } else {
            $qry4 = "UPDATE users SET casual_leave= $avaliableCLeave WHERE id = $mUserId  ";
            $result4 = $this->conn->query($qry4);
            return true;
        }
    }

    

    
}

?>