<?php

require_once __DIR__ . '/../model/Employeelogin.php';
require_once __DIR__ . '/../model/Attendance.php';

class DashboardController
{
    public function dashboardView(): void
    {
       

        if (!isset($_SESSION['admin']))
        {
            header("Location: index.php?page=login");

            exit;
        }

       

        $employeeModel = new Employeelogin();

        $attendanceModel = new Attendance();

        

        $employees = $employeeModel->getEmployee();

       

        $totalEmployees = count($employees);

       

        $attendanceRecords = $attendanceModel->getAllAttendance();

       
        $totalAttendance = count($attendanceRecords);

       

        $todayDate = date('Y-m-d');

        $todayAttendance = [];

        foreach ($attendanceRecords as $record)
        {
            if ($record['attendance_date'] == $todayDate)
            {
                $todayAttendance[] = $record;
            }
        }

       

        $totalPresentToday = count($todayAttendance);

        

        $searchDate = $_GET['date'] ?? '';

        $searchEmployee = $_GET['employee'] ?? '';

        if ($searchDate || $searchEmployee)
        {
            $attendanceRecords = $attendanceModel->searchAttendance(
                $searchDate,
                $searchEmployee
            );
        }

       

        require_once __DIR__ . '/../view/admin/dashboard.php';
    }
}