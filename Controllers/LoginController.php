<?php

require_once "./db connection/Database.php";
require_once "./Models/Teacher.php";
require_once "./Models/Student.php";
session_start();

class LoginController
{
    private ?PDO $conn;


    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function loginStudent(string $examCode, string $name, string $surname, string $studentID)
    {
        $insertStudent = $this->conn->prepare("insert into student(name, surname, studentID, testID) values (:name, :surname, :studentID, :testID)");
        $insertStudent->bindValue("name", $name);
        $insertStudent->bindValue("surname", $surname);
        $insertStudent->bindValue("studentID", $studentID);
        $insertStudent->bindValue("testID", $examCode);

        try {
            $insertStudent->execute();
            $_SESSION["loggedStudent"] = true;
            $_SESSION["name"] = $name;
            header("location: student.php");
        } catch (Exception $e) {
//            echo "Študent už existuje";
            returnAlert("Študent už existuje");
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
//            echo "Neplatné prihlásenie";
            returnAlert("Neplatné prihlásenie");
            return;
        }
        if (password_verify($password, $teacher->getPassword())) {
            if ($checked == 1) {
                setcookie("remember", true, time() + 18000);
            }
            $_SESSION["loggedTeacher"] = true;
            header("location: teacher/index.php");
        } else {
//            echo "Zlé heslo";
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
//            echo "Neplatná registrácia";
        }
    }
}

function returnAlert($message){
    echo "<div class='alert alert-danger' role='alert'>".
        $message.
        "</div>";
}