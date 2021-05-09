<?php
require_once "../db connection/Database.php";
require_once "../Models/Teacher.php";
require_once "../Models/Student.php";
require_once "../Models/Test.php";
session_start();

class TestGradingController
{
    private ?PDO $conn;
    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getTestForGrading($passTestID)
    {
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
                    $getMoreAns = $this->conn->prepare("SELECT pass_more_ans.ID as moreID, more_ans.title as optionTitle, pass_more_ans.check_ans as my_ans, IFNULL(!STRCMP(more_ans.check_ans, pass_more_ans.check_ans), 0) as point FROM pass_more_ans JOIN more_ans ON pass_more_ans.more_ans_ID=more_ans.ID where pass_more_ans.pass_question_ID = :question_ID");
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
                    $question["math_ans"]["value"] = $row["path"];
                    if (!empty($row["path"]) && str_starts_with($row["path"], '../img/scannedAnswers/mathAns')) {
                        $question["math_ans"]["type"] = "scanned";
                        if (!file_exists($row["path"])){
                            $question["pics_ans"]["value"] = null;
                        }
                    }else{
                        $question["math_ans"]["type"] = "editor";
                    }

                    $question["point"] = $row["correct"];
                    break;
                case "pics_ans":
                    $setPicsAns = $this->conn->prepare("SELECT ID, IFNULL(path, '') as path, correct FROM pass_pics_ans WHERE pass_question_ID=:question_ID");
                    $setPicsAns->bindValue("question_ID", $question["passQuestionId"]);
                    $setPicsAns->setFetchMode(PDO::FETCH_ASSOC);
                    $setPicsAns->execute();
                    $row = $setPicsAns->fetch();

                    $question["pics_ans"]["pass_id"] = $row["ID"];
                    $question["pics_ans"]["value"] = $row["path"];
                    if (!empty($row["path"]) && str_starts_with($row["path"], '../img/scannedAnswers/picsAns')) {
                        $question["pics_ans"]["type"] = "scanned";
                        if (!file_exists($row["path"])){
                            $question["pics_ans"]["value"] = null;
                        }
                    }else{
                        $question["pics_ans"]["type"] = "editor";
                    }
                    $question["point"] = $row["correct"];
                    break;
            }
        }
        return $studentsQuestions;
    }

    public function getTotalScore($passTestID)
    {
        $getQuestions = $this->conn->prepare("select pass_question.ID as passQuestionId, question.type as type from pass_question JOIN question ON pass_question.question_ID=question.ID where pass_test_ID =:passTestID");
        $getQuestions->bindValue("passTestID", $passTestID);
        $getQuestions->setFetchMode(PDO::FETCH_ASSOC);
        $getQuestions->execute();

        $score = 0;

        $studentsQuestions = $getQuestions->fetchAll();
        foreach ($studentsQuestions as &$question) {
            switch ($question["type"]) {
                case "short_ans":
                    $getShortAns = $this->conn->prepare("SELECT IFNULL(!STRCMP(pass_short_ans.my_ans, short_ans.correct_ans), 0) as point FROM pass_short_ans JOIN short_ans ON pass_short_ans.short_ans_ID = short_ans.ID  where pass_short_ans.pass_question_ID = :question_ID");
                    $getShortAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getShortAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getShortAns->execute();
                    while ($row = $getShortAns->fetch()) {
                        $score += $row["point"];
                    }
                    break;
                case "more_ans":
                    $getMoreAns = $this->conn->prepare("SELECT  IFNULL(!STRCMP(more_ans.check_ans, pass_more_ans.check_ans), 0) as point FROM pass_more_ans JOIN more_ans ON pass_more_ans.more_ans_ID=more_ans.ID where pass_more_ans.pass_question_ID = :question_ID");
                    $getMoreAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getMoreAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getMoreAns->execute();
                    $point = 1;
                    while ($row = $getMoreAns->fetch()) {
                        if($row["point"] == 0){
                            $point = 0;
                        }
                    }
                    $score += $point;
                    break;
                case "pair_ans":
                    $getPairAns = $this->conn->prepare("SELECT ( IFNULL(!STRCMP(pass_pair_ans.left_part, pair_ans.left_part), 0) AND IFNULL(!STRCMP(pass_pair_ans.right_part, pair_ans.right_part), 0)) as point FROM pass_pair_ans JOIN pair_ans ON pass_pair_ans.pair_ans_ID=pair_ans.ID where pass_pair_ans.pass_question_ID = :question_ID");
                    $getPairAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getPairAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getPairAns->execute();
                    $point = 1;
                    while ($row = $getPairAns->fetch()) {
                        if($row["point"] == 0){
                            $point = 0;
                        }
                    }
                    $score += $point;
                    break;
                case "math_ans":
                    $getMathAns = $this->conn->prepare("SELECT ID, IFNULL(path, '') as path, correct FROM pass_math_ans WHERE pass_question_ID=:question_ID");
                    $getMathAns->bindValue("question_ID", $question["passQuestionId"]);
                    $getMathAns->setFetchMode(PDO::FETCH_ASSOC);
                    $getMathAns->execute();
                    $row = $getMathAns->fetch();

                    $score += $row["correct"];
                    break;
                case "pics_ans":
                    $setPicsAns = $this->conn->prepare("SELECT ID, IFNULL(path, '') as path, correct FROM pass_pics_ans WHERE pass_question_ID=:question_ID");
                    $setPicsAns->bindValue("question_ID", $question["passQuestionId"]);
                    $setPicsAns->setFetchMode(PDO::FETCH_ASSOC);
                    $setPicsAns->execute();
                    $row = $setPicsAns->fetch();

                    $score += $row["correct"];
                    break;
            }
        }
        return $score;
    }

    public function getTestDetails($test_ID){
        $testBasicInfo = $this->conn->prepare("SELECT test.activation as active, test.title as title, COUNT(*) as questionCount FROM test JOIN question ON test.ID=question.test_ID WHERE test.ID=:test_id");
        $testBasicInfo->bindValue("test_id", $test_ID);
        $testBasicInfo->setFetchMode(PDO::FETCH_ASSOC);
        try {
            $testBasicInfo->execute();
            return $testBasicInfo->fetch();
        } catch (Exception $e) {
            $this->returnAlert($e);
        }
    }

    public function getStudentsPerTest($test_ID)
    {
        $testStudents = $this->conn->prepare("SELECT pass_test.id as studentID, pass_test.graded as graded, concat(student.surname, ' ', student.name) as name, student.studentID as IDStudent, pass_test.tab_focus as focus, pass_test.status as status FROM pass_test JOIN student ON pass_test.student_ID = student.id WHERE pass_test.test_ID=:test_id ORDER BY pass_test.tab_focus, student.surname  ASC;");
        $testStudents->bindValue("test_id", $test_ID);
        $testStudents->setFetchMode(PDO::FETCH_ASSOC);

        $records =[];
        try {
            $testStudents->execute();
            while ($row = $testStudents->fetch()) {
                if($row["status"] == 0){
                    $score = $this->getTotalScore($row["studentID"]);
                    $row["score"] = $score;
                }else{
                    $row["score"] = "x";
                }

                array_push($records, $row);
            }
            return $records;
        } catch (Exception $e) {
            $this->returnAlert($e);
        }
    }


    public function getAllStudentAnswers($passTestID)
    {
        $testStudents = $this->conn->prepare("SELECT pass_test.id as studentID, student.studentID as idNumber, concat(student.surname, ' ', student.name) as name FROM pass_test JOIN student ON pass_test.student_ID = student.id WHERE pass_test.test_ID=:test_id ORDER BY student.surname ASC;");
        $testStudents->bindValue("test_id", $passTestID);
        $testStudents->setFetchMode(PDO::FETCH_ASSOC);

        try {
            $testStudents->execute();
            $students = $testStudents->fetchAll();
            foreach ($students as &$student) {
                $student["questions"] = $this->getTestForGrading($student["studentID"]);
            }
            return $students;
        } catch (Exception $e) {
            $this->returnAlert($e);
        }
    }

    public function setPassMathCorrect($ans_ID, $correct){
        $updateQuestion = $this->conn->prepare("update pass_math_ans set correct=:correct where ID = :ans_ID");
        $updateQuestion->bindValue("correct", $correct);
        $updateQuestion->bindValue("ans_ID", $ans_ID);
        try {
            $updateQuestion->execute();
            return "success";
        } catch (Exception $e) {
            $this->returnAlert($e);
        }
    }

    public function setPassPicsCorrect($ans_ID, $correct){
        $updateQuestion = $this->conn->prepare("update pass_pics_ans set correct=:correct where ID = :ans_ID");
        $updateQuestion->bindValue("correct", $correct);
        $updateQuestion->bindValue("ans_ID", $ans_ID);
        try {
            $updateQuestion->execute();
            return "success";
        } catch (Exception $e) {
            $this->returnAlert($e);
        }
    }

    public function setGraded($passTestID){
        $updateGraded = $this->conn->prepare("update pass_test set graded=1 where ID = :pass_ID");
        $updateGraded->bindValue("pass_ID", $passTestID);

        $testID = $this->conn->prepare("SELECT test_ID FROM pass_test WHERE pass_test.ID=:test_id ;");
        $testID->bindValue("test_id", $passTestID);

        try {
            $updateGraded->execute();

            $testID->execute();

            $toGoBack = $testID->fetchAll();

            return $toGoBack[0]["test_ID"];
        } catch (Exception $e) {
            $this->returnAlert($e);
        }
    }


    function returnAlert($message){
        echo "<div class='alert alert-danger' role='alert'>".
            $message.
            "</div>";
    }


}