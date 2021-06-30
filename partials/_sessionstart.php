<?php
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $row["user_type"];
            $_SESSION["status"] = $row["status"];
            $_SESSION["fullname"] = join(" ", array($row["first_name"], $row["last_name"]));
?>