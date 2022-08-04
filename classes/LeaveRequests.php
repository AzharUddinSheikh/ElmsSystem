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

    public function totalLeaveRequested(int $id) : int
    {
        $sql = "SELECT * FROM leave_requests WHERE id = '$id'";

        $result = $this->conn->query($sql);
		
		$row = $result->fetch_assoc();
		
		$begin = new DateTime($row["start_date"]);
		$end = new DateTime($row["end_date"]);
	
        $count = 0;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $count++;
        }
        return $count;
    }

    public function getApprovedLeave(int $id) : int
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


    public function applyLeave(string $reason, string $date1, string $date2, int $id) : void
    {
		$time1 = strtotime($date1);
		if ($time1 === false) {
			throw new \Exception('Invalid date: ' . $date1);
		}
		$time2 = strtotime($date2);
		if ($time2 === false) {
			throw new \Exception('Invalid date: ' . $date2);
		}
        $new_date1 = date("Y-m-d", $time1);
        $new_date2 = date("Y-m-d", $time2);

        $sql = "INSERT INTO leave_requests (user_id, reason, start_date, end_date) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("isss", $id, $reason,  $new_date1, $new_date2);

        $stmt->execute();
    }

    public function pendingLeaveRequest() : object
    {
        $sql = "SELECT u.id as user_id, lr.id, u.emp_id, lr.reason, lr.start_date, lr.end_date, u.first_name, u.last_name FROM users u JOIN leave_requests lr ON u.id = lr.user_id WHERE lr.start_date > CURDATE() AND lr.status = 0 ORDER BY lr.id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function showUserLeave(string $id)
    {
        $sql = "SELECT lr.id, lr.start_date as 'start' , lr.end_date as 'end', lr.reason as excuse, ls.status, ls.reason, ls.from_date as 'from', ls.to_date as 'to' FROM leave_requests lr JOIN leave_status ls ON lr.id = ls.requests_id WHERE lr.user_id = '$id' ORDER BY lr.id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

	/**
	* @return array<int, mixed>
	*/
    public function gettingDate(string $encoded)
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