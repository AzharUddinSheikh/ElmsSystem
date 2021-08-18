<?php

namespace Azhar\ELMS;

class Users
{
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function showUserList() 
    {
        $sql = "SELECT * FROM departments d JOIN users u WHERE u.departments_id = d.id AND u.status != 0";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function getUserId($email){

        $sql = "SELECT emp_id FROM users WHERE email = '$email'";

        $result = $this->conn->query($sql);

        while($row = $result->fetch_assoc()) {

            return $row["emp_id"];
          }
    }

    public function createUser($empid, $fname, $lname, $email, $department, $usertype)
    {
        $query = "INSERT INTO  users (emp_id, first_name, last_name, email, departments_id, user_type) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('issssi', $empid, $fname, $lname, $email, $department, $usertype);

        $stmt->execute();

        $stmt->close();
    }

    public function checkUserExistence($email) 
    {
        $existsql = "SELECT * FROM users Where email = '$email'";

        $result = mysqli_query($this->conn, $existsql);

        return mysqli_num_rows($result);
    }

    public function getUserStatus($email)
    {
        $sql = "SELECT * FROM users Where email = '$email'";

        $result = $this->conn->query($sql);

        while ($row = $result->fetch_assoc()){

            return $row["status"];
        }
    }

    public function blockUser($id)
    {
        $sql =  "UPDATE users SET status = 2 WHERE id = $id";

        mysqli_query($this->conn, $sql);
    }

    public function unBlockUser($id)
    {
        $sql =  "UPDATE users SET status = 1 WHERE id = $id";

        mysqli_query($this->conn, $sql);
    }

    public function resetStatus($email)
    {
        $sql = "UPDATE users SET status = 0 WHERE email = '$email'";

        $this->conn->query($sql);
    }

    public function updateUser($fname, $lname, $email, $image, $id)
    {
        $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email', image = '$image' WHERE emp_id = '$id'";

        $result = $this->conn->query($sql);
    }

    public function saveProfileImage($img) 
    {
        $target = "../public/images/".basename($img);

        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE emp_id = '$id'";

        $this->conn->query($sql);
    }

    public function updatePassword($id, $pass)
    {
        $sql = "UPDATE users SET password = '$pass' WHERE id = '$id'";

        $this->conn->query($sql);

        echo "password changed successfully";
    }

    public function verified($id)
    {
        $sql = "SELECT * FROM users WHERE status = 0 AND emp_id = '$id' LIMIT 1";

        $result = $this->conn->query($sql);

        if ($result->num_rows != 1){

            return true;
        }
    }

    public function setPassword($pass, $id)
    {
        $sql = "SELECT * FROM users WHERE status = 0 AND emp_id = '$id' LIMIT 1";

        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {

            $setPass = password_hash($pass, PASSWORD_DEFAULT);

            $update = $this->conn->query("UPDATE users SET password = '$setPass',status = 1 WHERE emp_id = '$id' LIMIT 1");
        }
    }

    public function getUserWithDept($id)
    {
        $sql = "SELECT u.id, u.email, u.first_name, u.last_name, d.name, ud.user_value, u.image FROM users u JOIN user_details ud ON ud.user_id = u.id JOIN departments d ON u.departments_id = d.id WHERE user_key = 'number' AND u.id = '$id'";

        $result = $this->conn->query($sql);

        $detail = array();

        while ($row = $result->fetch_assoc()){
            array_push($detail, $row["name"], $row["email"], $row["user_value"], $row["first_name"], $row["last_name"], $row["id"], $row["image"]);
        }

        return $detail;
    }
}

?>