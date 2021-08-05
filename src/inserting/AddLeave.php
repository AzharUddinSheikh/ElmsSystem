<?php

namespace Azhar\ELMS\Inserting;
use \DateTime;

class AddLeave
{
    public function __construct($db, $id)
    {
        $this->id = $id;
        $this->conn = $db;
    }
    
    public function appLeave($reason, $date1, $date2)
    {
        $new_date1 = date("Y-m-d", strtotime($date1));
        $new_date2 = date("Y-m-d", strtotime($date2));
        
        $sql = "INSERT INTO leave_requests (user_id, reason, start_date, end_date) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bind_param("isss", $this->id, $reason,  $new_date1, $new_date2);
        
        $stmt->execute();
    }
    
    public function eachDay($date1, $date2)
    {
        $result = $this->conn->query("SELECT id FROM leave_requests WHERE user_id = $this->id ORDER BY id DESC LIMIT 1");
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
}

?>