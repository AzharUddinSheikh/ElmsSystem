<?php

namespace Azhar\ELMS;

class GeneralSetting
{
    private $conn;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    public function enterYear($enyear,$cyear)
    {
        $sql = "INSERT INTO general_setting ( value) VALUES(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $enyear );
        $stmt->execute();
        $stmt->close();


    }

    // public function enterYear($enyear,$cyear)
    // {
    //     $year_key = 'Current year';
    //     $sql = "INSERT INTO general_setting ( key , value) VALUES(?,?)";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param('ii', $cyear, $enyear );
    //     $stmt->execute();
    //     $stmt->close();


    // }

    public function readGeneral()
    {
        $sql = "SELECT * FROM general_setting ";
        $result = $this->conn->query($sql);
        $showall =[];
        while($row = $result->fetch_assoc())
        {
            $showall[]= $row;
        }
        return $showall;
    }

    // public function updateLeave($enyear,$cyear)
    // {
    //     if($enyear != $cyear)
    //     {
    //         $sql = "UPDATE users SET 	casual_leave = 50, medical_leave = 50, privilege_leave=50";
    //         $result = $this->conn->query($sql);
    //         return true;
    //     }
    // }

    public function enYear($enterYear) 
    {
        $checkyear = "CurrentYear";
        $sql = "UPDATE general_setting SET value = '$enterYear' WHERE arrayKey = '$checkyear' ";
        $result = $this->conn->query($sql);
        // die($enyear);
        

    }
    public function readAll()
    {
       $sql = "SELECT * FROM general_setting ";
       $result = $this->conn->query($sql);
    //    $show = $result->fetch_assoc();
       $new = [];
       while($row = $result->fetch_assoc()){
        $new[]= $row;
       }
       return $new;

    }

    public function yearlyLeave($cYear,$enterYear)
    {
        if($enterYear != $cYear)
        {
            $sql = "UPDATE users SET 	casual_leave = 50, medical_leave = 50, privilege_leave=50";
            $result = $this->conn->query($sql);
            return true;
        }
    }

}    