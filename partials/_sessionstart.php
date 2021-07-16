<?php
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $row["user_type"];
            $_SESSION["status"] = $row["status"];
            $_SESSION["id"] = $row["user_id"];
            $_SESSION["emp_id"] = $row["emp_id"];
            $_SESSION["last_login_timestamp"] = time();
?>