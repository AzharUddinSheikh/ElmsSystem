<?php

namespace Azhar\ELMS\Inserting;

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

?>