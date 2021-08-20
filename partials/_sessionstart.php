<?php
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $row["user_type"];
            $_SESSION["first"] = $row["first_name"];
            $_SESSION["last"] = $row["last_name"];
            $_SESSION["status"] = $row["status"];
            $_SESSION["id"] = $row["user_id"];
            $_SESSION["emp_id"] = $row["emp_id"];
?>