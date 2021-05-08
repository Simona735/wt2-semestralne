<?php
require_once "../db connection/Database.php";
require_once "../Models/Teacher.php";
require_once "../Models/Student.php";
require_once "../Models/Test.php";
session_start();

class TestGradingController
{
    private ?PDO $conn;
    private $questions;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getTestForGrading($passTestID){
        $getQuestions = $this->conn->prepare("select pass_question.ID as passQuestionId, question.title as title, question.type as type from pass_question JOIN question ON pass_question.question_ID=question.ID where pass_test_ID =:passTestID");
        $getQuestions->bindValue("passTestID", $passTestID);
        $getQuestions->setFetchMode(PDO::FETCH_ASSOC);
        $getQuestions->execute();

        $studentsQuestions = $getQuestions->fetchAll();
        foreach ($studentsQuestions as &$question) {
            switch ($question["type"]) {
                case "short_ans":
                    $getShortAns = $this->conn->prepare("SELECT IFNULL(pass_short_ans.my_ans, '-' ) as my_ans, IFNULL(!STRCMP(pass_short_ans.my_ans, short_ans.correct_ans), 0) as point FROM pass_short_ans JOIN short_ans ON pass_short_ans.short_ans_ID = short_ans.ID  where pass_short_ans.pass_question_ID = :question_ID");
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
                    $getPairAns = $this->conn->prepare("SELECT pass_pair_ans.ID as pairID, IFNULL(pass_pair_ans.left_part, '-' ) as my_left, IFNULL(pass_pair_ans.right_part, '-' ) as my_right,( IFNULL(!STRCMP(pass_pair_ans.left_part, pair_ans.left_part), 0) AND IFNULL(!STRCMP(pass_pair_ans.right_part, pair_ans.right_part), 0)) as point FROM pass_pair_ans JOIN pair_ans ON pass_pair_ans.pair_ans_ID=pair_ans.ID where pass_pair_ans.pass_question_ID = :question_ID");
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
                    $setPicsAns = $this->conn->prepare("SELECT ID, IFNULL(path, '') as path, correct FROM pass_pics_ans WHERE pass_question_ID=:question_ID");
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

    public function getTestDetails($test_ID){
        $testBasicInfo = $this->conn->prepare("SELECT test.activation as active, test.title as title, COUNT(*) as questionCount FROM test JOIN question ON test.ID=question.test_ID WHERE test.ID=:test_id");
        $testBasicInfo->bindValue("test_id", $test_ID);
        $testBasicInfo->setFetchMode(PDO::FETCH_ASSOC);
        try {
            $testBasicInfo->execute();
            return $testBasicInfo->fetch();
        } catch (Exception $e) {
            returnAlert($e);
        }
    }

    public function getStudentsPerTest($test_ID) {
        $testStudents = $this->conn->prepare("SELECT student.id as studentID, pass_test.graded as graded, concat(student.surname, ' ', student.name) as name, pass_test.tab_focus as focus, pass_test.status as status FROM pass_test JOIN student ON pass_test.student_ID = student.id WHERE pass_test.test_ID=:test_id ORDER BY pass_test.tab_focus, student.surname  ASC;");
        $testStudents->bindValue("test_id", $test_ID);
        $testStudents->setFetchMode(PDO::FETCH_ASSOC);

        $records =[];
        try {
            $testStudents->execute();
            while ($row = $testStudents->fetch()) {
                array_push($records, $row);
            }
            return $records;
        } catch (Exception $e) {
            returnAlert($e);
        }
    }

    function returnAlert($message){
        echo "<div class='alert alert-danger' role='alert'>".
            $message.
            "</div>";
    }


}