<?php 

include '_db.php';

if(isset($_POST["dep_name"])) {
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    $depart = new Department($_POST["dep_name"], $db);
    
    echo $depart->check_dept();
}

if(isset($_POST["user_email"])) {
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    $emp = new Employee($db, $_POST["user_email"]);

    echo $emp->check_user();
}



?>