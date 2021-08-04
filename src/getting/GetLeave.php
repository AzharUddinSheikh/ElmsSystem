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
    
    public function userLeaveModal($id)
    {
        $sql = "SELECT * FROM leave_requests WHERE user_id = '$id' ORDER BY added_on DESC";
        
        $result = $this->conn->query($sql);

        $count = 0;
        $response =
        '<table class="table table-dark table-striped my-3" id="myTable">
        <thead>
            <tr>
                <th scope="col">Sno</th>
                <th scope="col">Reason</th>
                <th scope="col">Added-On</th>
                <th scope="col">StartDate</th>
                <th scope="col">EndDate</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>';

        while ($row = $result->fetch_assoc()){
            $count++;
            $response .= 
            '<tr>
                <td>'.$count.'</td>
                <td>'.$row['reason'].'</td>
                <td>'.$row['added_on'].'</td>
                <td>'.$row['start_date'].'</td>
                <td>'.$row['end_date'].'</td>
                <td><button class="userdetails btn btn-info" id="'.base64_encode($row["id"]).'">Check Status</button></td>
            </tr>';
        }

        $response .= '</tbody>';

        return $response;
    }
}

?>
<script>
document.querySelectorAll('.userdetails').forEach((element)=>{
    element.addEventListener("click",(e)=>{
        id = e.target.id.substr(0,);
        window.location = `/elms/twig/twigAdmin.php?userdetails=${id}`
    })
})
</script>