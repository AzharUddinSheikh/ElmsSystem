<?php 

include '_db.php';

$database = new Database();
$db = $database->getConnection();


if(isset($_POST["dep_name"])) {
   
    $depart = new Department($_POST["dep_name"], $db);
    
    echo $depart->checkDept();
}

if(isset($_POST["user_email"])) {

    $emp = new Employee($db, $_POST["user_email"]);
    
    echo $emp->checkUser();
}

if(isset($_POST["dname"])) {
    
    $dep = new Department($_POST["dname"], $db);

    $dep->create();

    echo "data successfully inserted";
}
?>