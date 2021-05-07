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

    public function setFocus($pass_id, $focus){
        $setFocus = $this->conn->prepare("UPDATE pass_test SET tab_focus=:focus WHERE pass_test.ID=:pass_id");
        $setFocus->bindValue("pass_id", $pass_id);
        $setFocus->bindValue("focus", $focus);
        try {
            $setFocus->execute();
            return "success";
        }catch (Exception $e){
            $this->returnAlert($e);
        }
    }


    public function getTestForGrading($passTestID){
        $getQuestions = $this->conn->prepare("select pass_question.ID as passQuestionId, question.title as title, question.type as type from pass_question JOIN question ON pass_question.question_ID=question.ID where pass_test_ID =:passTestID");
        $getQuestions->bindValue("passTestID", $passTestID);
        $getQuestions->setFetchMode(PDO::FETCH_ASSOC);
        $getQuestions->execute();

        $studentsQuestions = $getQuestions->fetchAll();
        foreach ($studentsQuestions as $question) {
            switch ($question["type"]) {
                case "short_ans":
                    $getShortAns = $this->conn->prepare("SELECT IFNULL(pass_short_ans.my_ans, '' ) as my_ans, IFNULL(!STRCMP(pass_short_ans.my_ans, short_ans.correct_ans), 0) as point FROM pass_short_ans JOIN short_ans ON pass_short_ans.short_ans_ID = short_ans.ID  where pass_short_ans.pass_question_ID = :question_ID");
                    $getShortAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getShortAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getShortAns->execute();
                    while ($row = $getShortAns->fetch()) {
                        $question["short_ans"] = $row["my_ans"];
                        $question["point"] = $row["point"];
                    }
                    break;
                case "more_ans":
                    $getMoreAns = $this->conn->prepare("SELECT pass_short_ans.ID as moreID, more_ans.title as optionTitle, pass_more_ans.check_ans as my_ans, IFNULL(!STRCMP(more_ans.check_ans, pass_more_ans.check_ans), 0) as point FROM pass_more_ans JOIN more_ans ON pass_more_ans.more_ans_ID=more_ans.ID where pass_more_ans.pass_question_ID = :question_ID");
                    $getMoreAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getMoreAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getMoreAns->execute();
                    $point = 1;
                    while ($row = $getMoreAns->fetch()) {
                        $question["more_ans"][$row["moreID"]] = $row;
                        if($row["point"] == 0){
                            $point = 0;
                        }
                    }
                    $question["point"] = $point;
                    break;
                case "pair_ans":
                    $getPairAns = $this->conn->prepare("SELECT pass_pair_ans.ID as pairID, IFNULL(pass_pair_ans.left_part, '' ) as my_left, IFNULL(pass_pair_ans.right_part, '' ) as my_right,( IFNULL(!STRCMP(pass_pair_ans.left_part, pair_ans.left_part), 0) AND IFNULL(!STRCMP(pass_pair_ans.right_part, pair_ans.right_part), 0)) as point FROM pass_pair_ans JOIN pair_ans ON pass_pair_ans.pair_ans_ID=pair_ans.ID where pass_pair_ans.pass_question_ID = :question_ID");
                    $getPairAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getPairAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getPairAns->execute();
                    $point = 1;
                    while ($row = $getPairAns->fetch()) {
                        $question["pair_ans"][$row["pairID"]] = $row;
                        if($row["point"] == 0){
                            $point = 0;
                        }
                    }
                    $question["point"] = $point;
                    break;
                case "math_ans":
                    $getMathAns = $this->conn->prepare("SELECT ID, IFNULL(path, '') as path, correct FROM pass_math_ans WHERE pass_question_ID=:question_ID");
                    $getMathAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getMathAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getMathAns->execute();
                    $row = $getMathAns->fetch();

                    $question["math_ans"]["pass_id"] = $row["ID"];
                    if (!empty($row["path"]) && str_starts_with($row["path"], '../img/scannedAnswers/mathAns') && file_exists($row["path"])) {
                        $question["math_ans"]["type"] = "scanned";
                    }else{
                        $question["math_ans"]["type"] = "editor";
                    }
                    $question["math_ans"]["value"] = $row["path"];
                    $question["point"] = $row["correct"];
                    break;
                case "pics_ans":
                    $setPicsAns = $this->conn->prepare("SELECT ID, IFNULL(path, ''), correct FROM pass_pics_ans WHERE pass_question_ID=:question_ID");
                    $setPicsAns->bindValue("question_ID", $question["passQuestionId"]);
                    $setPicsAns->setFetchMode(PDO::FETCH_ASSOC);
                    $setPicsAns->execute();
                    $row = $setPicsAns->fetch();

                    $question["pics_ans"]["pass_id"] = $row["ID"];
                    if (!empty($row["path"]) && str_starts_with($row["path"], '../img/scannedAnswers/picsAns') && file_exists($row["path"])) {
                        $question["pics_ans"]["type"] = "scanned";
                    }else{
                        $question["pics_ans"]["type"] = "editor";
                    }
                    $question["pics_ans"]["value"] = $row["path"];
                    $question["point"] = $row["correct"];
                    break;
            }
        }
        return $studentsQuestions;
    }

    function returnAlert($message){
        echo "<div class='alert alert-danger' role='alert'>".
            $message.
            "</div>";
    }

}