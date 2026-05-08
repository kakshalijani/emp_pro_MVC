<?php

require_once __DIR__ . '/../model/Attendance.php';

class AttendanceController
{
   

    public function punchIn()
    {
       
        if (!isset($_SESSION['employee']))
        {
            header("Location: index.php?page=login");
            exit;
        }


        $employeeId = $_SESSION['employee']['id'];

        

        $attendanceModel = new Attendance();

        

        $result = $attendanceModel->punchIn($employeeId);

        

        if ($result === "already_punched_in")
        {
            $_SESSION['message'] = "You already punched in today";

            $_SESSION['message_type'] = "error";

            header("Location: index.php?page=empdashboard");

            exit;
        }

        
        $_SESSION['message'] = "Punch In Successful";

        $_SESSION['message_type'] = "success";

        header("Location: index.php?page=empdashboard");

        exit;
    }

    

    public function punchOut()
    {
       

        if (!isset($_SESSION['employee']))
        {
            header("Location: index.php?page=login");
            exit;
        }

        

        $employeeId = $_SESSION['employee']['id'];

       

        $attendanceModel = new Attendance();

       
        $result = $attendanceModel->punchOut($employeeId);

       
        if ($result === "please_punch_in_first")
        {
            $_SESSION['message'] = "Please Punch In First";

            $_SESSION['message_type'] = "error";

            header("Location: index.php?page=empdashboard");

            exit;
        }

       
        if ($result === "already_punched_out")
        {
            $_SESSION['message'] = "You already punched out today";

            $_SESSION['message_type'] = "error";

            header("Location: index.php?page=empdashboard");

            exit;
        }


        $_SESSION['message'] = "Punch Out Successful";

        $_SESSION['message_type'] = "success";

        header("Location: index.php?page=empdashboard");

        exit;
    }
}