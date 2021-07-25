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
        $new_date1 = date("Y-m-d", strtotime($date1));
        $new_date2 = date("Y-m-d", strtotime($date2));
        $min = min(strtotime($date2), strtotime($date1));
        $today = date('Y-m-d');

        $sql = "INSERT INTO leave_requests (user_id, reason, start_date, end_date) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("isss", $this->id, $reason,  $new_date1, $new_date2);

        $stmt->execute();

        return true;
    }
}

?>