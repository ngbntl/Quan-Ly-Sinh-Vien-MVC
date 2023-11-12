<?php
include_once("../Model/M_Student.php");

class Ctrl_Student
{
    public function invoke()
    {
        if (isset($_GET['stid'])) {
            $modelStudent = new Model_Student();
            $student = $modelStudent->getStudentDetail($_GET['stid']);
            include_once("../View/StudentDetail.html");
        } else if (isset($_GET['action']) && $_GET['action'] === 'add') {
            include_once("../View/AddStudent.html");
        } else if (isset($_GET['action']) && $_GET['action'] === 'search') {
            include_once("../View/SearchStudent.html");
        } else if (isset($_POST['searchStudent'])) {
            $key = $_POST['key'];
            $searchBy = $_POST['searchBy'];

            $modelStudent = new Model_Student();
            $studentList = $modelStudent->searchStudent($key, $searchBy);
            include_once("../View/StudentList.html");
        } else if (isset($_GET['action']) && $_GET['action'] == 'update') {
            $stid = $_GET['id'];
            $modelStudent = new Model_Student();
            if (!empty($stid)) {
                $student = $modelStudent->getStudentDetail($_GET['id']);
                include_once("../View/UpdateStudent.html");
            } else {
                echo "Error:Vui lòng Điền đủ thông tin!";
            }
        } elseif (isset($_POST['update'])) {
            $id = $_POST['txtId'];
            $name = $_POST['txtName'];
            $age = $_POST['txtAge'];
            $university = $_POST['txtUni'];

            $modelStudent = new Model_Student();

            if (!empty($name) && !empty($age) && !empty($university)) {
                $result = $modelStudent->updateStudent($id, $name, $age, $university);

                if ($result) {
                    $studentList = $modelStudent->getAllStudents();
                    include_once("../View/StudentList.html");
                } else {
                    echo "Error: Cập nhật sinh viên thất bại.";
                }
            } else {
                echo "Error: Vui lòng điền đầy đủ thông tin.";
            }
        } else if (isset($_POST['addStudent'])) {
            $id = $_POST['txtId'];
            $name = $_POST["txtName"];
            $age = $_POST["txtAge"];
            $university = $_POST["txtUni"];

            $modelStudent = new Model_Student();
            if (!empty($id) && !empty($name) && !empty($age) && !empty($university)) {
                $result = $modelStudent->addNewStudent($id, $name, $age, $university);
                if ($result) {
                    $studentList = $modelStudent->getAllStudents();
                    include_once("../View/StudentList.html");
                }
            } else {
                echo "Error: Điền đủ tt!";
            }
        } else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $stid = $_GET['id'];
            $modelStudent = new Model_Student();
            if (!empty($stid)) {
                $rs = $modelStudent->deleteStudent($stid);
                if ($rs) {
                    $studentList = $modelStudent->getAllStudents();
                    include_once('../View/StudentList.html');
                } else {
                    echo 'Delete Failed';
                }
            } else {
                echo 'Not Found Student ID';
            }
        } else {
            $modelStudent = new Model_Student();
            $studentList = $modelStudent->getAllStudents();
            include_once("../View/StudentList.html");

        }
    }

}
;
$C_Student = new Ctrl_Student();
$C_Student->invoke();
?>