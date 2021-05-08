<?php
require_once "../Controllers/CreateTestController.php";
$buildTest = new BuildTestController();
session_start();

if (isset($_POST["addQuestion"]) and $_POST["addQuestion"]){
    $result = $buildTest->addQuestion($_POST["T_ID"], $_POST["Q_Title"], $_POST["Q_Type"]);
    switch ($_POST["Q_Type"]){
        case "short_ans":
            $lastID = $buildTest->addShortAns($result["question_id"], "");
            $result["short_ans_id"] = $lastID;
            echo json_encode($result);
            break;
        case "more_ans":
            $lastIDFirst = $buildTest->addMoreAns($result["question_id"], "", 0);
            $lastIDSecond = $buildTest->addMoreAns($result["question_id"], "", 0);
            $result["more_ans_id_1"] = $lastIDFirst;
            $result["more_ans_id_2"] = $lastIDSecond;
            echo json_encode($result);
            break;
        case "pair_ans":
            $lastIDFirst = $buildTest->addPairAns($result["question_id"], "", "");
            $lastIDSecond = $buildTest->addPairAns($result["question_id"], "", "");
            $result["pair_ans_id_1"] = $lastIDFirst;
            $result["pair_ans_id_2"] = $lastIDSecond;
            echo json_encode($result);
            break;
        case "pics_ans":
        case "math_ans":
            echo json_encode($result);
            break;
    }
}

if (isset($_POST["appendEmptyOption"]) and $_POST["appendEmptyOption"]) {
    switch ($_POST["Q_Type"]){
        case "more_ans":
            $lastID = $buildTest->addMoreAns($_POST["Q_ID"], "", 0);
            echo $lastID;
            break;
        case "pair_ans":
            $lastID = $buildTest->addPairAns($_POST["Q_ID"], "", "");
            echo $lastID;
            break;
    }
}

if (isset($_POST["question_ID"])) {
    $result = $buildTest->deleteQuestion($_POST["question_ID"]);
    echo json_encode($result);
}

if (isset($_POST["update_QValue"])) {
    switch ($_POST["update_QValue"]) {
        case "question_title":
            $id = explode("-", $_POST["Q_ID"])[1];
            $result = $buildTest->updateQuestionTitle($id, $_POST["Q_Title"]);
            echo json_encode($result);
            break;
        case "shortAns_correct":
            $id = explode("-", $_POST["SA_ID"])[1];
            $result = $buildTest->updateShortAnsCorrect($id, $_POST["SA_Correct"]);
            echo json_encode($result);
            break;
        case "moreAns_title":
            $id = explode("-", $_POST["MA_ID"])[1];
            $result = $buildTest->updateMoreAnsTitle($id, $_POST["MA_Title"]);
            echo json_encode($result);
            break;
        case "moreAns_correct":
            $id = explode("-", $_POST["MA_ID"])[1];
            $result = $buildTest->updateMoreAnsCorrect($id, ($_POST["MA_Correct"] === 'true'? 1: 0));
            echo json_encode($result);
            break;
        case "pairAns_title":
            $id = explode("-", $_POST["PA_ID"])[1];
            $side = explode("-", $_POST["PA_ID"])[0];
            $result = $buildTest->updatePairAnsTitle($id, $_POST["PA_Title"], $side);
            echo json_encode($result);
            break;
    }
}

if (isset($_POST["test_ID"])) {
    $result = $buildTest->builtTest($_POST["test_ID"]);
    echo json_encode($result);
}