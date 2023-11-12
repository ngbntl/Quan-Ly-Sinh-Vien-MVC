<?php
include_once("E_Student.php");
include_once("db.php");
class Model_Student
{
    private $db;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function getAllStudents()
    {
        $query = "SELECT * FROM sinhvien";
        $result = $this->db->conn->query($query);

        if ($result) {
            $students = array();

            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }

            return $students;
        } else {
            echo "Error: " . $this->db->conn->error;
            return array();
        }
    }
    public function getStudentDetail($stid)
    {
        $sql = "SELECT * from sinhvien where id = ?";
        $stmt = $this->db->conn->prepare($sql);

        $stmt = $this->db->conn->prepare($sql);
        // Bind the parameters to our prepared statement
        $stmt->bind_param("i", $stid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $stmt->close();
            return $student;
        } else {
            $stmt->close();
            return array();
        }

    }
    public function addNewStudent($id, $name, $age, $university)
    {
        $check = "SELECT * FROM sinhvien WHERE id=?";
        $cstmt = $this->db->conn->prepare($check);
        $cstmt->bind_param("i", $id);
        $cstmt->execute();
        $checkRs = $cstmt->get_result();
        if ($checkRs->num_rows > 0) {
            echo "Đã tồn tại sinh viên có id: " . $id;
            return false;
        }

        $sql = "INSERT INTO sinhvien (id,name,age,university) VALUES (?,?,?,?)";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param('isss', $id, $name, $age, $university);
        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Error: ' . $stmt->error;
            return false;
        }

    }
    public function searchStudent($key, $searchBy)
    {
        $sql = "SELECT * FROM sinhvien";
        if ($searchBy == "id") {
            $sql .= " WHERE id = '$key'";
        } elseif ($searchBy == "name") {
            $sql .= " WHERE name = '$key'";
        } elseif ($searchBy == "age") {
            $sql .= " WHERE age = '$key'";
        } elseif ($searchBy == "university") {
            $sql .= " WHERE university = '$key'";
        }
        $rs = $this->db->conn->query($sql);
        if ($rs) {
            $students = array();

            while ($row = $rs->fetch_assoc()) {
                $students[] = $row;
            }
            return $students;
        } else {
            echo "Error: " . $this->db->conn->error;
            return array();
        }

    }
    public function updateStudent($id, $name, $age, $university)
    {
        $query = "UPDATE sinhvien SET name = ?, age = ?, university = ? WHERE id = ?";

        $stmt = $this->db->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sisi", $name, $age, $university, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    public function deleteStudent($id)
    {
        $query = "DELETE FROM sinhvien WHERE id=?";
        $stmt = $this->db->conn->prepare($query);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }
}






?>