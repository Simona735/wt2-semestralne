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
            $setPassQuestion = $this->conn->prepare("insert into pass_question(question_ID, pass_test_ID) values (:question_ID, :pass_test_ID)");
            $setPassQuestion->bindValue("question_ID", $question["ID"]);
            $setPassQuestion->bindValue("pass_test_ID", $_SESSION["passTestId"]);
            $setPassQuestion->execute();
            $passQuestionID = $this->conn->lastInsertId();
            switch ($question["type"]) {
                case "short_ans":
                    $getShortAns = $this->conn->prepare("select * from short_ans where question_ID = :question_ID");
                    $getShortAns->bindValue("question_ID", $question["ID"]);
                    $getShortAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getShortAns->execute();
                    while ($row = $getShortAns->fetch()) {
                        $setAns = $this->conn->prepare("insert into pass_short_ans(pass_question_ID, short_ans_ID) values (:question_ID, :short_ans_ID)");
                        $setAns->bindValue("question_ID", $passQuestionID);
                        $setAns->bindValue("short_ans_ID", $row["ID"]);
                        $setAns->execute();
                        $row["pass_id"] = $this->conn->lastInsertId();
                        $question["short_ans"] = $row;
                    }
                    break;
                case "more_ans":
                    $getMoreAns = $this->conn->prepare("select * from more_ans where question_ID = :question_ID");
                    $getMoreAns->bindValue("question_ID", $question["ID"]);
                    $getMoreAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getMoreAns->execute();
                    while ($row = $getMoreAns->fetch()) {
                        $setAns = $this->conn->prepare("insert into pass_more_ans(pass_question_ID, more_ans_ID) values (:question_ID, :more_ans_ID)");
                        $setAns->bindValue("question_ID", $passQuestionID);
                        $setAns->bindValue("more_ans_ID", $row["ID"]);
                        $setAns->execute();
                        $row["pass_id"] = $this->conn->lastInsertId();
                        $question["more_ans"][$row["ID"]] = $row;
                    }
                    break;
                case "pair_ans":
                    $helper = [];
                    $getPairAns = $this->conn->prepare("select * from pair_ans where question_ID = :question_ID");
                    $getPairAns->bindValue("question_ID", $question["ID"]);
                    $getPairAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getPairAns->execute();
                    while ($row = $getPairAns->fetch()) {
                        $setAns = $this->conn->prepare("insert into pass_pair_ans(pass_question_ID, pair_ans_ID) values (:question_ID, :pair_ans_ID)");
                        $setAns->bindValue("question_ID", $passQuestionID);
                        $setAns->bindValue("pair_ans_ID", $row["ID"]);
                        $setAns->execute();
                        array_push($helper, $row["left_part"]);
                        $row["pass_id"] = $this->conn->lastInsertId();
                        $question["pair_ans"][$row["ID"]] = $row;
                    }
                    shuffle($helper);
                    $i = 0;
                    foreach ($question["pair_ans"] as &$questionPart){
                        $questionPart["left_part"] = $helper[$i++];
                    }
                    break;
                case "math_ans":
                    $setAns = $this->conn->prepare("insert into pass_math_ans(pass_question_ID) values (:question_ID)");
                    $setAns->bindValue("question_ID", $passQuestionID);
                    $setAns->execute();
                    $question["math_ans"]["pass_id"] = $this->conn->lastInsertId();
                    break;
                case "pics_ans":
                    $setAns = $this->conn->prepare("insert into pass_pics_ans(pass_question_ID) values (:question_ID)");
                    $setAns->bindValue("question_ID", $passQuestionID);
                    $setAns->execute();
                    $question["pics_ans"]["pass_id"] = $this->conn->lastInsertId();
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

    public function updatePassShortAns($short_ans_ID, $my_ans){
        $updateQuestion = $this->conn->prepare("update pass_short_ans set my_ans = :my_ans where ID = :short_ans_ID");
        $updateQuestion->bindValue("my_ans", $my_ans);
        $updateQuestion->bindValue("short_ans_ID", $short_ans_ID);
        try {
            $updateQuestion->execute();
            return "success";
        } catch (Exception $e) {
            $this->returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updatePassMoreAns($moreAns_ID, $my_ans){
        $updateMoreAns = $this->conn->prepare("update pass_more_ans set check_ans = :my_ans where ID = :moreAns_ID");
        $updateMoreAns->bindValue("my_ans", $my_ans);
        $updateMoreAns->bindValue("moreAns_ID", $moreAns_ID);
        try {
            $updateMoreAns->execute();
            return "success";
        } catch (Exception $e) {
            $this->returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function updatePassPairAns($pairAns_ID, $left, $right){
        $updateMoreAns = $this->conn->prepare("update pass_pair_ans set left_part = :left_part, right_part = :right_part where ID = :pairAns_ID");
        $updateMoreAns->bindValue("left_part", $left);
        $updateMoreAns->bindValue("right_part", $right);
        $updateMoreAns->bindValue("pairAns_ID", $pairAns_ID);
        try {
            $updateMoreAns->execute();
            return "success";
        } catch (Exception $e) {
            $this->returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    public function setPassMathAns($ans_ID, $path){
        $updateQuestion = $this->conn->prepare("update pass_math_ans set path = :path where ID = :ans_ID");
        $updateQuestion->bindValue("path", $path);
        $updateQuestion->bindValue("ans_ID", $ans_ID);
        try {
            $updateQuestion->execute();
            return "Uploaded";
        } catch (Exception $e) {
            $this->returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    //Simin na qr scany
    public function setPassPicsAns($ans_ID, $path){
        $updateQuestion = $this->conn->prepare("update pass_pics_ans set path = :path where ID = :ans_ID");
        $updateQuestion->bindValue("path", $path);
        $updateQuestion->bindValue("ans_ID", $ans_ID);
        try {
            $updateQuestion->execute();
            return "Uploaded";
        } catch (Exception $e) {
            $this->returnAlert($e);
//            echo "Neplatná registrácia";
        }
    }

    //Branov na canvas
    public function updateDrawAns($draw_id, $newDraw){
        $updateDrawAns = $this->conn->prepare("update pass_pics_ans set path = :newDraw where ID = :draw_id");
        $updateDrawAns->bindValue("newDraw", $newDraw);
        $updateDrawAns->bindValue("draw_id", $draw_id);
        try {
            $updateDrawAns->execute();
            return "success";
        }catch (Exception $e){
            $this->returnAlert($e);
        }
    }

    public function getTimer($pass_id){
        $getTimer = $this->conn->prepare("SELECT test_start as ZaciatokTestu, duration as CelkovyCasNaTest FROM pass_test JOIN test ON test.ID=pass_test.test_ID WHERE pass_test.ID=:pass_id");
        $getTimer->bindValue("pass_id", $pass_id);
        $getTimer->setFetchMode(PDO::FETCH_ASSOC);
        try {
            $getTimer->execute();
            return $getTimer->fetch();
        }catch (Exception $e){
            $this->returnAlert($e);
        }
    }

    function returnAlert($message){
        echo "<div class='alert alert-danger' role='alert'>".
            $message.
            "</div>";
    }

}