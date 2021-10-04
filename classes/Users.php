<?php

namespace Azhar\ELMS;

class Users
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function showUserList() : object
    {
        $sql = "SELECT * FROM departments d JOIN users u WHERE u.department_id = d.id AND u.status != 0";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function getUserId(string $email) : string
	{
        $sql = "SELECT emp_id FROM users WHERE email = '$email'";

        $result = $this->conn->query($sql);

        while($row = $result->fetch_assoc()) {

            $result = $row["emp_id"];
          }
		
		return $result;
    }

    public function createUser(int $empid, string $fname, string $lname, string $email, int $department, int $usertype) : void
    {
        $query = "INSERT INTO  users (emp_id, first_name, last_name, email, department_id, user_type) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('issssi', $empid, $fname, $lname, $email, $department, $usertype);

        $stmt->execute();

        $stmt->close();
    }

    public function checkUserExistence(string $email)
    {
        $existsql = "SELECT * FROM users Where email = '$email'";

        $result = $this->conn->query($existsql);

        $result =  mysqli_num_rows($result);
		
		return $result;
    }

    public function getUserStatus(string $email) : string
    {
        $sql = "SELECT * FROM users Where email = '$email'";

        $result = $this->conn->query($sql);

        return $result->fetch_assoc()["status"];
    }

    public function blockUser(int $id) : void
    {
        $sql =  "UPDATE users SET status = 2 WHERE id = $id";

        mysqli_query($this->conn, $sql);
    }

    public function unBlockUser(int $id) : void
    {
        $sql =  "UPDATE users SET status = 1 WHERE id = $id";

        mysqli_query($this->conn, $sql);
    }

    public function resetStatus(string $email) : void
    {
        $sql = "UPDATE users SET status = 0 WHERE email = '$email'";

        $this->conn->query($sql);
    }

    public function updateUser(string $fname, string $lname, string $email, string $image, int $id) : void
    {
        $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email', image = '$image' WHERE emp_id = '$id'";

        $this->conn->query($sql);
    }

    public function saveProfileImage(string $img) : void 
    {
        $target = "../public/images/".basename($img);

        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    public function deleteUser(int $id) : void
    {
        $sql = "DELETE FROM users WHERE emp_id = '$id'";

        $this->conn->query($sql);
    }

    public function updatePassword(int $id, string $pass) : void
    {
        $sql = "UPDATE users SET password = '$pass' WHERE id = '$id'";

        $this->conn->query($sql);

        echo "password changed successfully";
    }

    public function verified(int $id) : bool
    {
        $sql = "SELECT * FROM users WHERE status = 0 AND emp_id = '$id' LIMIT 1";

        $result = $this->conn->query($sql);

        if ($result->num_rows != 1){

            $result =  true;
			
        } else {
			
			$result =  false;
		}
		
		return $result;
    }

    public function setPassword(string $pass, int $id) : void
    {
        $sql = "SELECT * FROM users WHERE status = 0 AND emp_id = '$id' LIMIT 1";

        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {

            $setPass = password_hash($pass, PASSWORD_DEFAULT);

            $this->conn->query("UPDATE users SET password = '$setPass',status = 1 WHERE emp_id = '$id' LIMIT 1");
        }
    }
	
	/**
	* @return array<int, mixed>
	*/
    public function getUserWithDept(int $id) 
    {
        $sql = "SELECT u.id, u.email, u.first_name, u.last_name, d.name, ud.user_value, u.image, u.user_type FROM users u JOIN user_details ud ON ud.user_id = u.id JOIN departments d ON u.department_id = d.id WHERE user_key = 'number' AND u.id = '$id'";

        $result = $this->conn->query($sql);

        $detail = array();

        while ($row = $result->fetch_assoc()){
            array_push($detail, $row["name"], $row["email"], $row["user_value"], $row["first_name"], $row["last_name"], $row["id"], $row["image"], $row["user_type"]);
        }

        return $detail;
    }

    public function validPass(string $form_pass, string $password, int $user_type, array $row) : void
    {
        if (password_verify($form_pass, $password)) {

            include 'partials/_sessionstart.php';

            if ($user_type == '1') {

                header("location:twig/admin.php");

            } else {

                header("location:twig/welcome.php");
            }
        }
    }

    public function validUser(string $email) : array
    {
        $sql = "SELECT * FROM users u JOIN user_details ud ON u.id = ud.user_id WHERE u.email='$email'";

        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {

            $result =  $result->fetch_assoc();

            }
		return $result;
    }

    public function checkPassword(int $id, string $oldpass) : bool
    {
        $sql = "SELECT * FROM users WHERE users.id = '$id' LIMIT 1"; 

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        if (!password_verify($oldpass, $row["password"])) {

            return false;

        } else {

            return true;
        }
    }
}

?>