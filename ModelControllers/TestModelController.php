<?php
require_once "../Controllers/TestController.php";
$test = new TestController();


if(isset($_POST["activeState"]) && isset($_POST["testId"])){
    $test->setActivation($_POST["activeState"], $_POST["testId"]);
}

if (isset($_POST["update_AValue"])){
    switch ($_POST["update_AValue"]){
        case "shortAns":
            $id = explode("-", $_POST["SA_ID"])[1];
            $result = $test->updatePassShortAns($id, $_POST["SA_ans"]);
            echo json_encode($result);
            break;
        case "moreAns":
            $id = explode("-", $_POST["MA_ID"])[1];
            $result = $test->updatePassMoreAns($id, ($_POST["MA_ans"] === 'true'? 1: 0));
            echo json_encode($result);
            break;
        case "pairAns":
            $id = explode("-", $_POST["PA_ID"])[1];
            $result = $test->updatePassPairAns($id, $_POST["PAL_ans"], $_POST["PAR_ans"]);
            echo json_encode($result);
            break;
        case "picsAns":
            break;
        case "drawAns":
            break;
    }
}