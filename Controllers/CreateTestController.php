<?php
require_once "../db connection/Database.php";
require_once "../Models/Teacher.php";
require_once "../Models/Student.php";
session_start();

class AddTestController
{
    private ?PDO $conn;


    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function addTest($title, $duration){
        $addTest = $this->conn->prepare("insert into test(title, duration, teacher_ID) values (:title, :duration, :teacher_ID)");
        $addTest->bindValue("title", $title);
        $addTest->bindValue("duration", $duration);
        $addTest->bindValue("teacher_ID", $_SESSION['loggedTeacher']);
        try {
            $addTest->execute();
            header("location: newTest.php?testID=".$this->conn->lastInsertId()."&title=".$title);
        } catch (Exception $e) {
            returnAlert("Nesprávne údaje pre vytvorenie testu" . $e);
//            echo "Neplatná registrácia";
        }
    }
}

class BuildTestController {
    private ?PDO $conn;


    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function addQuestion($test_ID, $title, $type){
        $addQuestion = $this->conn->prepare("insert into question(test_ID, title, type) values (:test_ID, :title, :type)");
        $addQuestion->bindValue("test_ID", $test_ID);
        $addQuestion->bindValue("title", $title);
        $addQuestion->bindValue("type", $type);
        try {
            $addQuestion->execute();
            return [
                'title' => $title,
                'question_id' => $this->conn->lastInsertId()
            ];
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function deleteQuestion($question_ID){
        $deleteQuestion = $this->conn->prepare("delete from question where ID = :question_ID");
        $deleteQuestion->bindValue("question_ID", $question_ID);
        $deleteShortAns = $this->conn->prepare("delete from short_ans where question_ID = :question_ID");
        $deleteShortAns->bindValue("question_ID", $question_ID);
        $deleteMoreAns = $this->conn->prepare("delete from more_ans where question_ID = :question_ID");
        $deleteMoreAns->bindValue("question_ID", $question_ID);
        $deletePairsAns = $this->conn->prepare("delete from pair_ans where question_ID = :question_ID");
        $deletePairsAns->bindValue("question_ID", $question_ID);
        try {
            $deleteShortAns->execute();
            $deleteMoreAns->execute();
            $deletePairsAns->execute();
            $deleteQuestion->execute();
            return "success";
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updateQuestionTitle($question_ID, $title){
        $updateQuestion = $this->conn->prepare("update question set title = :title where ID = :question_ID");
        $updateQuestion->bindValue("title", $title);
        $updateQuestion->bindValue("question_ID", $question_ID);
        try {
            $updateQuestion->execute();
            return "success";
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function addShortAns($question_ID, $correct) {
        $addShortAns = $this->conn->prepare("insert into short_ans(question_ID, correct_ans) values (:question_ID, :correct_ans)");
        $addShortAns->bindValue("question_ID", $question_ID);
        $addShortAns->bindValue("correct_ans", $correct);
        try {
            $addShortAns->execute();
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updateShortAnsCorrect($shortAns_ID, $correct){
        $updateQuestion = $this->conn->prepare("update short_ans set correct_ans = :correct_ans where ID = :shortAns_ID");
        $updateQuestion->bindValue("correct_ans", $correct);
        $updateQuestion->bindValue("shortAns_ID", $shortAns_ID);
        try {
            $updateQuestion->execute();
            return "success";
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function addMoreAns($question_ID, $title, $check_ans) {
        $addMoreAns = $this->conn->prepare("insert into more_ans(question_ID, title, check_ans) values (:question_ID, :title, :check_ans)");
        $addMoreAns->bindValue("question_ID", $question_ID);
        $addMoreAns->bindValue("title", $title);
        $addMoreAns->bindValue("check_ans", $check_ans);
        try {
            $addMoreAns->execute();
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updateMoreAnsTitle($moreAns_ID, $title){
        $updateMoreAns = $this->conn->prepare("update more_ans set title = :title where ID = :moreAns_ID");
        $updateMoreAns->bindValue("title", $title);
        $updateMoreAns->bindValue("moreAns_ID", $moreAns_ID);
        try {
            $updateMoreAns->execute();
            return "success";
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updateMoreAnsCorrect($moreAns_ID, $correct){
        $updateMoreAns = $this->conn->prepare("update more_ans set check_ans = :check_ans where ID = :moreAns_ID");
        $updateMoreAns->bindValue("check_ans", $correct);
        $updateMoreAns->bindValue("moreAns_ID", $moreAns_ID);
        try {
            $updateMoreAns->execute();
            return "success";
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function addPairAns($question_ID, $left_part, $right_part) {
        $addPairAns = $this->conn->prepare("insert into pair_ans(question_ID, left_part, right_part) values (:question_ID, :left_part, :right_part)");
        $addPairAns->bindValue("question_ID", $question_ID);
        $addPairAns->bindValue("left_part", $left_part);
        $addPairAns->bindValue("right_part", $right_part);
        try {
            $addPairAns->execute();
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updatePairAnsTitle($pairAns_ID, $title, $side){
        $updatePairAns = null;
        if ($side == "left")
            $updatePairAns = $this->conn->prepare("update pair_ans set left_part = :title where ID = :pairAns_ID");
        else if ($side == "right")
            $updatePairAns = $this->conn->prepare("update pair_ans set right_part = :title where ID = :pairAns_ID");
        $updatePairAns->bindValue("title", $title);
        $updatePairAns->bindValue("pairAns_ID", $pairAns_ID);
        try {
            $updatePairAns->execute();
            return "success";
        } catch (Exception $e) {
            returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }
}

function returnAlert($message){
    echo "<div class='alert alert-danger' role='alert'>".
        $message.
        "</div>";
}