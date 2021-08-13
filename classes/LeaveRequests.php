<?php

namespace Azhar\ELMS;
use \DateTime;

class LeaveRequests
{

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function deleteUserRequest($id)
    {
        $sql = "DELETE FROM leave_requests WHERE id = $id";

        mysqli_query($this->conn, $sql);
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
        $sql = "SELECT ld.status FROM users u JOIN leave_requests lr on  u.id = lr.user_id join leave_details ld on lr.id = ld.leave_id where ld.status = 1 and YEAR(ld.leave_applied) = YEAR(CURDATE()) AND emp_id = '$id'";

        $result = mysqli_query($this->conn, $sql);

        $row = mysqli_num_rows($result);

        return $row;
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
        $sql = "SELECT * FROM users JOIN leave_requests WHERE users.id = leave_requests.user_id AND leave_requests.start_date > CURDATE() AND leave_requests.status = 0 ORDER BY leave_requests.id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function showUserLeave($id)
    {
        $sql = "SELECT * FROM leave_requests WHERE user_id = '$id' ORDER BY ID DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function getEachLeaveStatus($id)
    {
        $sql = "SELECT * FROM leave_details WHERE leave_id = '$id'";

        $result = $this->conn->query($sql);

        $count = 0;
        $response = 
        '<table class="table table-dark table-striped my-3">
        <thead>
        <tr>
        <th scope="col">Sno</th>
            <th scope="col">Leave Date</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>';
        while ($row = $result->fetch_assoc()){
            
            if ($row['status'] == 0){
                $status = "PENDING";
            } elseif ($row['status'] == 1){
                $status = "APPROVED";
            } else {
                $status = "REJECTED";
            }

            $count++;
            $response .= 
            '<tr>
                <td>'.$count.'</td>
                <td>'.$row['leave_applied'].'</td>
                <td>'.$status.'</td>
            </tr>';
        }
        $response .= '</tbody>';

        return $response;
    }
}

?>