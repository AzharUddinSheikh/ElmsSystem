<?php

namespace Azhar\ELMS\Inserting;

class AddLeave
{
    public function __construct($db, $id)
    {
        $this->id = $id;
        $this->conn = $db;
    }
    
    public function appLeave($reason, $date1, $date2)
    {
        if (($date1 != $date2) && ($date1 != date('Y-m-d')) && (strtotime($date2) - strtotime($date1) > 86400) && ((strtotime($date2) || strtotime($date1)) > strtotime(date('Y-m-d')))) {
            $sql = "INSERT INTO leave_requests (user_id, reason, start_date, end_date) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("isss", $this->id, $reason,  $date1, $date2);
            $stmt->execute();
            $stmt->close();
            echo '<script>alert("Leave Has Been Applied")</script>';
        } else {
            echo '<script>alert("Invalid Date")</script>';
        }
        
    }
}

?>