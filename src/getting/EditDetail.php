<?php

namespace Azhar\ELMS\Getting;

class EditDetail
{
    public static function detailEdit($db, $id)
    {
        $sql = "SELECT * FROM users JOIN user_details WHERE users.id = user_details.user_id AND users.id = '$id'";
        $result = $db->query($sql);
        $count = 0;
        $detail = array();
        while ($row = $result->fetch_assoc()){
            $count++;
            if ($count % 2 != 0){
                $first_name = $row["first_name"];
                $last_name = $row["last_name"];
                $email = $row["email"];
                $birth_day = $row["user_value"];
                array_push($detail, $first_name, $last_name, $email, $birth_day);
            } else {
                $emp_id = $row["emp_id"];
                $phone_number = $row["user_value"];
                $image = $row["image"];
                array_push($detail, $phone_number, $emp_id, $image);
            }
        }
        return $detail;
    }

}

?>