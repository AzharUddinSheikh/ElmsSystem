<?php

namespace Azhar\ELMS;

class Notification
{
    private $conn;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function enterRequest($id, $documentAskStatus, $userid, $type, $message)
    {
        $query = "INSERT INTO notification (request_id, document_ask_notify, user_id, type, message) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('iiiis', $id, $documentAskStatus, $userid, $type, $message);

        $stmt->execute();

        $stmt->close();
    }

    public function notificationNumber($id) 
    {
        $qry = "SELECT * FROM notification WHERE user_id= $id && document_ask_notify = 1 ";
        $result = $this->conn->query($qry);
        $showNumber = mysqli_num_rows($result);
        $show = $result->fetch_assoc();
        $notificationid = !empty($show['id'])?$show['id']:"";
        return [$showNumber,$notificationid];
    }

    public function display($id)
    {
        $qry ="SELECT * FROM notification WHERE document_ask_notify = 1 && user_id = $id";
        $result =  $this->conn->query($qry);
        return $result;

    }

    public function displayNumber()
    {
        $qry ="SELECT * FROM notification ";
        $result =  $this->conn->query($qry);
        $show = $result->fetch_assoc();
        $showNumber = !empty($show['document_ask_notify'])?$show['document_ask_notify']:"";
        return $showNumber;
    }

    public function updateRequestInLeave($id)
    {
        $qry =" UPDATE leave_requests SET document_ask = 1 WHERE id = $id";
        $result = $this->conn->query($qry);
        return true;
    }

    public function funcInsertPhoto($filename, $requestid)
    {

        $qry1="update notification set image_document = '$filename' where request_id = $requestid";
        $result = $this->conn->query($qry1);
        return true;
    
    }

    public function updateNotification($requestid)
    {
        $qry=" UPDATE notification SET document_ask_notify = 0 WHERE request_id = $requestid";
        $result = $this->conn->query($qry);
        return true;
    }

    public function updateViewButton($requestid)
    {
        $qry=" UPDATE leave_requests SET view_image = 1 WHERE id = $requestid";
        $result = $this->conn->query($qry);
        return true;
    }


    public function viewImage($requestid)
    {
        $qry = "SELECT * FROM notification WHERE request_id = $requestid";
        $result = $this->conn->query($qry);
        $show = $result->fetch_assoc();
        $showImage = $show['image_document'];
        return $showImage;
    }
    
    


}

?>