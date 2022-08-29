<?php



use Azhar\Elms\Database;
use Azhar\Elms\Notification;

$database = new Database();
$db = $database->getConnection();


$notification = new Notification($db);

$id = $_SESSION['id'];

$messageDisplay = $notification->display($id);
$displayData = array();
while ($row = $messageDisplay->fetch_assoc()) {
    array_push($displayData, $row);
}

[$notificationNumber, $notificationid] = $notification->notificationNumber($id);


?>