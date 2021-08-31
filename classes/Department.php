<?php

namespace Azhar\ELMS;

class Department
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function update(string $name, string $encoded) : void
    {
        $id = base64_decode($encoded);

        $sql = "UPDATE departments SET name = '$name' WHERE id = '$id'";

        $this->conn->query($sql);
    }

    public function delete(string $encoded) : void
    {
        $id = base64_decode($encoded);

        $sql = "DELETE FROM departments WHERE id = '$id'";

        $this->conn->query($sql);
    }

    public function showList() : object
    {
        $sql = "SELECT * FROM departments ORDER BY id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }

    public function isExists(string $dept_name) : int|string
    {
        $existsql = "SELECT * FROM departments WHERE name = '$dept_name'";

        $result = $this->conn->query($existsql);

        return mysqli_num_rows($result);
    }

    public function create(string $dept_name) : void
    {
        $query = "INSERT INTO  departments (name) VALUES (?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $dept_name);

        $stmt->execute();

        $stmt->close();
    }

    public function noOfUserInDept(int $id) : object
    {
        $sql = "SELECT d.name, u.emp_id, u.email, u.first_name, u.last_name, u.id as user_id FROM departments d JOIN users u ON d.id = u.department_id WHERE d.id = '$id'";

        $result = $this->conn->query($sql);

        return $result;
    }
}

?>