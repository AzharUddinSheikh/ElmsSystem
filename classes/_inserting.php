<?php

namespace AddingDetail;

class Employee
{
    private $conn;
    private $email;

    public function __construct($db, $email) 
    {
        $this->conn = $db;
        $this->email = $email;
    
    }

    public function createDetail($number, $dob)
    {
        $result = $this->conn->query("SELECT id FROM users WHERE `email`= '$this->email'");
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

        $stmt->close();

        header('location: ../partials/thankyou.php');
    }

    public function createUser($empid, $fname, $lname, $department, $usertype)
    {
        $query = "INSERT INTO  users (emp_id, first_name, last_name, email, department_id, user_type) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('issssi', $empid, $fname, $lname, $this->email, $department, $usertype);
        
        $stmt->execute();

        $stmt->close();
    }

    public function checkUser() 
    {
        $existsql = "SELECT * FROM users Where email = '$this->email'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);
    }
}

class Department
{
    private $dept_name; 
    private $conn;

    public function __construct($dept_name, $db)
    {
        $this->dept_name = $dept_name;
        $this->conn = $db;
    }

    public function checkDept()
    {
        $existsql = "SELECT * FROM departments WHERE name = '$this->dept_name'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);
    }

    public function create()
    {
        $query = "INSERT INTO  departments (name) VALUES (?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $this->dept_name);
        
        $stmt->execute();

        $stmt->close();
    }
}

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