<?php

namespace Azhar\ELMS;

class UserDetails
{

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function gettingUserDetail($id)
    {
        $sql = "SELECT * FROM users JOIN user_details WHERE users.id = user_details.user_id AND users.emp_id = '$id'";
        $result = $this->conn->query($sql);
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

    public function createUserDetails($number, $dob, $email)
    {
        $result = $this->conn->query("SELECT id FROM users WHERE `email`= '$email'");
        $last_id = (int)$result->fetch_assoc()["id"];
        $birth_key = 'birthday';
        $phone_key = 'number';

        for ($x = 0; $x < 2; $x++) {

            $query = "INSERT INTO user_details (user_id, user_key, user_value) VALUES(?, ?, ?)";

            $stmt = $this->conn->prepare($query);

            if ($x == 0) {

                $stmt->bind_param('iss', $last_id, $birth_key, $dob);

            } else {

                $stmt->bind_param('isi', $last_id, $phone_key, $number);

            }

            $stmt->execute();
        }
    }

    public function updateUserDetails($birthday, $number, $id)
    {
        for ($x = 0; $x < 2; $x++) {

            if ($x == 0) {

                $sql = "UPDATE user_details ud JOIN users u ON ud.user_id = u.id SET ud.user_value = '$birthday' WHERE u.emp_id = '$id' AND ud.user_key='birthday'";

            } else {

                $sql = "UPDATE user_details ud JOIN users u ON ud.user_id = u.id SET ud.user_value = '$number' WHERE u.emp_id = '$id' AND ud.user_key='number'";

            }
            $this->conn->query($sql);
        }
    }
}

?>