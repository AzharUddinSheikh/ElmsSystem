<?php

namespace Azhar\ELMS\Updating;

class EditEmp
{
    public function __construct($db, $id)
    {
        $this->conn = $db;
        $this->id = $id;
    }
   
    public function img_folder($img) 
    {
        $target = "../public/images/".basename($img);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }
    
    public function updateUser($fname, $lname, $email, $image)
    {
        $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email', image = '$image' WHERE id = '$this->id'";
        $result = $this->conn->query($sql);
    }
   
    public function updateUserDetail($birthday, $number)
    {
        for ($x = 0; $x < 2; $x++) {
            
            if ($x == 0) {
                
                $sql = "UPDATE user_details SET user_value = '$birthday' WHERE user_id = '$this->id' AND user_key='birthday'";
                
            } else {
                
                $sql = "UPDATE user_details SET user_value = '$number' WHERE user_id= '$this->id' AND user_key='number'";

            }

            $this->conn->query($sql);

        }

    }
}

?>