<?php

require_once __DIR__ . '/Database.php';

class Attendance
{
    private $conn;

    

    public function __construct()
    {
        $db = new Database();

        $this->conn = $db->connect();

        if (!$this->conn)
        {
            die("Database Connection Failed");
        }
    }

    

    public function getTodayAttendance($employeeId)
    {
        $today = date('Y-m-d');

        $sql = "SELECT *
                FROM attendance
                WHERE employee_id = ?
                AND attendance_date = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param("is", $employeeId, $today);

        $stmt->execute();

        $result = $stmt->get_result();

        $attendance = $result->fetch_assoc();

        $stmt->close();

        return $attendance;
    }

    

    public function punchIn($employeeId)
    {
        

        $existingAttendance = $this->getTodayAttendance($employeeId);

        if ($existingAttendance)
        {
            return "already_punched_in";
        }

        $today = date('Y-m-d');

        $currentDateTime = date('Y-m-d H:i:s');

        $status = "Present";

        $sql = "INSERT INTO attendance
                (
                    employee_id,
                    attendance_date,
                    punch_in,
                    status
                )
                VALUES
                (
                    ?, ?, ?, ?
                )";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param(
            "isss",
            $employeeId,
            $today,
            $currentDateTime,
            $status
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

   

    public function punchOut($employeeId)
    {

        $attendance = $this->getTodayAttendance($employeeId);

        

        if (!$attendance)
        {
            return "please_punch_in_first";
        }

        

        if (!empty($attendance['punch_out']))
        {
            return "already_punched_out";
        }

        
        $punchOutTime = date('Y-m-d H:i:s');

       

        $punchInTimestamp = strtotime($attendance['punch_in']);

        $punchOutTimestamp = strtotime($punchOutTime);

        $totalSeconds = $punchOutTimestamp - $punchInTimestamp;

        $hours = floor($totalSeconds / 3600);

        $minutes = floor(($totalSeconds % 3600) / 60);

        $totalWorkingHours = $hours . " hrs " . $minutes . " mins";

       

        $sql = "UPDATE attendance
                SET
                    punch_out = ?,
                    total_hours = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssi",
            $punchOutTime,
            $totalWorkingHours,
            $attendance['id']
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    
    public function getAttendanceHistory($employeeId)
    {
        $sql = "SELECT *
                FROM attendance
                WHERE employee_id = ?
                ORDER BY attendance_date DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param("i", $employeeId);

        $stmt->execute();

        $result = $stmt->get_result();

        $history = [];

        while ($row = $result->fetch_assoc())
        {
            $history[] = $row;
        }

        $stmt->close();

        return $history;
    }

    

    public function getMonthlySummary($employeeId)
    {
        $month = date('m');

        $year = date('Y');

        $sql = "SELECT COUNT(*) as total_present
                FROM attendance
                WHERE employee_id = ?
                AND MONTH(attendance_date) = ?
                AND YEAR(attendance_date) = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param(
            "iii",
            $employeeId,
            $month,
            $year
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $summary = $result->fetch_assoc();

        $stmt->close();

        return $summary;
    }

    

    public function getAllAttendance()
    {
        $sql = "SELECT
                    attendance.*,
                    Employee.full_name,
                    Employee.email
                FROM attendance
                JOIN Employee
                ON attendance.employee_id = Employee.id
                ORDER BY attendance.attendance_date DESC";

        $result = $this->conn->query($sql);

        $attendance = [];

        while($row = $result->fetch_assoc())
        {
            $attendance[] = $row;
        }

        return $attendance;
    }

    
    public function searchAttendance($date = null, $employee = null)
    {
        $sql = "SELECT
                    attendance.*,
                    Employee.full_name,
                    Employee.email
                FROM attendance
                JOIN Employee
                ON attendance.employee_id = Employee.id
                WHERE 1=1";

        $params = [];

        $types = "";

        

        if (!empty($date))
        {
            $sql .= " AND attendance.attendance_date = ?";

            $params[] = $date;

            $types .= "s";
        }

        
        if (!empty($employee))
        {
            $sql .= " AND Employee.full_name LIKE ?";

            $params[] = "%$employee%";

            $types .= "s";
        }

        $sql .= " ORDER BY attendance.attendance_date DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        if (!empty($params))
        {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        $attendance = [];

        while($row = $result->fetch_assoc())
        {
            $attendance[] = $row;
        }

        $stmt->close();

        return $attendance;
    }

    

    public function getAttendanceById($id)
    {
        $sql = "SELECT *
                FROM attendance
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $attendance = $result->fetch_assoc();

        $stmt->close();

        return $attendance;
    }

    

    public function updateAttendance(
        $id,
        $punchIn,
        $punchOut,
        $totalHours,
        $status
    )
    {
        $sql = "UPDATE attendance
                SET
                    punch_in = ?,
                    punch_out = ?,
                    total_hours = ?,
                    status = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssssi",
            $punchIn,
            $punchOut,
            $totalHours,
            $status,
            $id
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    

    public function deleteAttendance($id)
    {
        $sql = "DELETE FROM attendance
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt)
        {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }
}