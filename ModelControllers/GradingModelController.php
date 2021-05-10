<?php
require_once "../Controllers/TestGradingController.php";
$test = new TestGradingController();


if (isset($_POST["passTestID"])){
    foreach($_POST as $x => $x_value) {
        $pass_question = explode("-", $x);
        if($pass_question[0] == "math"){
            $test->setPassMathCorrect($pass_question[1], $x_value);
        }else if($pass_question[0] == "pics"){
            $test->setPassPicsCorrect($pass_question[1], $x_value);
        }
    }

    $result = $test->setGraded($_POST["passTestID"]);

    header("location: ../teacher/testState.php?test=".$result);
}

if (isset($_POST["tabNotification"]) && isset($_POST["teacher"])){
    $result = $test->getNotifications($_POST["teacher"]);

    echo json_encode($result);
}
