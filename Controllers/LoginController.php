<?php

session_start();
class LoginController
{
    public function loginStudent(string $examCode, string $name, string $surname, string $studentID){
        // TODO login student
        $_SESSION["loggedStudent"] = true;
        $_SESSION["name"] = $name;
        header("location: dashboard-student.php");
    }

    public function loginTeacher(string $email, string $password, bool $checked){
        // TODO login teacher
        if($checked == 1){
            setcookie("remember", true, time() + 18000);
        }
        $_SESSION["loggedTeacher"] = true;
        header("location: dashboard-teacher.php");
    }

    public function registerTeacher(){
        //TODO register teacher
        header("location: index.php");
    }
}
