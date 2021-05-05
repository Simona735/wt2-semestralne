<?php

require_once "./db connection/Database.php";
require_once "./Models/Teacher.php";
require_once "./Models/Student.php";
require_once "./Models/Test.php";
session_start();

class LoginController
{
    private ?PDO $conn;


    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function loginStudent(string $testId, string $name, string $surname, string $studentID)
    {
        $insertStudent = $this->conn->prepare("insert into student(name, surname, studentID) values (:name, :surname, :studentID)");
        $insertStudent->bindValue("name", $name);
        $insertStudent->bindValue("surname", $surname);
        $insertStudent->bindValue("studentID", $studentID);

        $insertStudentTest = $this->conn->prepare("insert into student_test(student_id, test_id) values (:student_id, :test_id)");
        $insertStudentTest->bindValue("test_id", $testId);

        try {
            $insertStudent->execute();

            $studentDBID = $this->conn->lastInsertId();
            $insertStudentTest->bindValue("student_id", $studentDBID);

            $insertStudentTest->execute();

            $_SESSION["loggedStudent"] = true;
            $_SESSION["name"] = $name;
            header("location: student/student.php");
        } catch (Exception $e) {
            returnAlert("Študent už existuje".$e);
        }
    }

    public function checkTest($testCode){
        $getTest = $this->conn->prepare("select * from test where test_code = :code");
        $getTest->bindValue("code", $testCode);
        $getTest->setFetchMode(PDO::FETCH_CLASS, "Test");
        $getTest->execute();
        $test = $getTest->fetch();

        if ($test == null) {
            returnAlert("Neplatný kód");
            return -1;
        }

        if ($test->isActivation()) {
            $_SESSION["testID"] = $test->getTestCode();
            return $test->getID();
        } else {
            returnAlert("Test nie je prístupný");
            return -1;
        }
    }

    public function loginTeacher(string $email, string $password, bool $checked)
    {
        $getTeacher = $this->conn->prepare("select * from teacher where email = :email");
        $getTeacher->bindValue("email", $email);
        $getTeacher->setFetchMode(PDO::FETCH_CLASS, "Teacher");
        $getTeacher->execute();
        $teacher = $getTeacher->fetch();
        if ($teacher == null) {
            returnAlert("Neplatné prihlásenie");
            return;
        }
        if (password_verify($password, $teacher->getPassword())) {
            if ($checked == 1) {
                setcookie("remember", $teacher->getID(), time() + 18000);
            }
            $_SESSION["loggedTeacher"] = $teacher->getID();
            header("location: teacher/index.php");
        } else {
            returnAlert("Zlé heslo");
            session_destroy();
        }
    }

    public function registerTeacher($name, $surname, $email, $password)
    {
        $setTeacher = $this->conn->prepare("insert into teacher(name, surname, email, password) values (:name, :surname, :email, :password)");
        $setTeacher->bindValue("name", $name);
        $setTeacher->bindValue("surname", $surname);
        $setTeacher->bindValue("email", $email);
        $setTeacher->bindValue("password", password_hash($password, PASSWORD_DEFAULT));
        //$setTeacher->bindValue("password", $password);
        try {
            $setTeacher->execute();
            header("location: index.php");
        } catch (Exception $e) {
            returnAlert("Neplatná registrácia");
        }
    }
}

function returnAlert($message){
    echo "<div class='alert alert-danger' role='alert'>".
        $message.
        "</div>";
}
