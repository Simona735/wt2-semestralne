<?php
require_once "../db connection/Database.php";
require_once "../Models/Teacher.php";
require_once "../Models/Student.php";
require_once "../Models/Test.php";
session_start();

class TestController
{
    private ?PDO $conn;
    private $questions;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getTest($testCode){
        $getTest = $this->conn->prepare("select * from test where test_code = :code");
        $getTest->bindValue("code", $testCode);
        $getTest->setFetchMode(PDO::FETCH_CLASS, "Test");
        $getTest->execute();
        $test = $getTest->fetch();
        $getQuestions = $this->conn->prepare("select * from question where test_ID = :test_ID");
        $getQuestions->bindValue("test_ID", $test->getID());
        $getQuestions->setFetchMode(PDO::FETCH_ASSOC);
        $getQuestions->execute();
        $this->questions = $getQuestions->fetchAll();
        foreach ($this->questions as &$question) {
            switch ($question["type"]) {
                case "short_ans":
                    $getShortAns = $this->conn->prepare("select * from short_ans where question_ID = :question_ID");
                    $getShortAns->bindValue("question_ID", $question["ID"]);
                    $getShortAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getShortAns->execute();
                    $result = $getShortAns->fetchAll();
                    $question["short_ans"][$result[0]["ID"]] = $result;
                    break;
                case "more_ans":
                    $getMoreAns = $this->conn->prepare("select * from more_ans where question_ID = :question_ID");
                    $getMoreAns->bindValue("question_ID", $question["ID"]);
                    $getMoreAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getMoreAns->execute();
                    $result = $getMoreAns->fetchAll();
                    $question["more_ans"][$result[0]["ID"]] = $result;
                    break;
                case "pair_ans":
                    $getPairAns = $this->conn->prepare("select * from pair_ans where question_ID = :question_ID");
                    $getPairAns->bindValue("question_ID", $question["ID"]);
                    $getPairAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getPairAns->execute();
                    $result = $getPairAns->fetchAll();
                    $question["pair_ans"][$result[0]["ID"]] = $result;
                    break;
            }
        }
        return $this->questions;
    }

    public function setActivation($activeSTate, $testID){
        $setState = $this->conn->prepare("UPDATE test SET activation=:activation WHERE ID = :id");
        $setState->bindValue("activation", $activeSTate);
        $setState->bindValue("id", $testID);
        try{
            $setState->execute();
            echo $activeSTate;
        }catch (Exception $e) {
//            echo "Neplatná registrácia";
        }

    }

    function returnAlert($message){
        echo "<div class='alert alert-danger' role='alert'>".
            $message.
            "</div>";
    }

}