<?php

class AdminModel {

    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllEmployees()
    {
        return $this->conn->query("SELECT * FROM Employee")->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllAttendance()
    {
        $sql = "SELECT a.*, e.name 
                FROM Attendance a
                JOIN Employee e ON a.employee_id = e.id";

        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function searchAttendance($keyword)
    {
        $sql = "SELECT a.*, e.name 
                FROM Attendance a
                JOIN Employee e ON a.employee_id = e.id
                WHERE e.name LIKE '%$keyword%' 
                OR a.work_date LIKE '%$keyword%'";

        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getAttendanceById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Attendance WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updateAttendance($id, $in, $out, $status)
    {
        $stmt = $this->conn->prepare(
            "UPDATE Attendance SET punch_in=?, punch_out=?, status=? WHERE id=?"
        );

        $stmt->bind_param("sssi", $in, $out, $status, $id);
        return $stmt->execute();
    }

    public function deleteAttendance($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Attendance WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}