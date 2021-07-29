<?php

// starting session 
session_start();

session_unset();

session_destroy();

session_start();

$_SESSION["flash"] = "LOGOUT OUT SUCCESSFULLY";

header("location: ../index.php");

exit;

?>