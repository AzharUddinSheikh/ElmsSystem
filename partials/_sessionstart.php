<?php
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $row["user_type"];
            $_SESSION["status"] = $row["status"];
            $_SESSION["emp_id"] = $row["emp_id"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["status"] = $row["status"];
            $_SESSION["uservalue"] = $row["user_value"];
            $_SESSION["fullname"] = join(" ", array($row["first_name"], $row["last_name"]));
            $_SESSION["last_login_timestamp"] = time();
?>