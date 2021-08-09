<?php

namespace Azhar\ELMS\Getting;

class GetLeave
{
    private $sql;
    private $conn;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function isMaxLeave($id)
    {
        $sql = "SELECT ld.status FROM users u JOIN leave_requests lr on  u.id = lr.user_id join leave_details ld on lr.id = ld.leave_id where ld.status = 1 and YEAR(ld.leave_applied) = YEAR(CURDATE()) AND emp_id = '$id'";

        $result = mysqli_query($this->conn, $sql);

        $row = mysqli_num_rows($result);

        return $row;
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

    public function leaveRequest()
    {
        $sql = "SELECT * FROM users JOIN leave_requests WHERE users.id = leave_requests.user_id AND leave_requests.start_date > CURDATE() AND leave_requests.status = 0 ORDER BY leave_requests.id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function userLeave($id)
    {
        $sql = "SELECT * FROM leave_requests WHERE user_id = '$id' ORDER BY ID DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function getEachLeave($id)
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
