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


if(isset($_POST["passTestID"]) && isset($_POST["questionType"])){
    $target_dir = "../img/scannedAnswers/";
    $target_file = $target_dir . basename($_FILES["scannedImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["scannedImage"]["error"] != 0) {
        header("location: ../scanDoc.php?alert=PleaseTryAgain");
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        unlink($target_file);
    }

    // Check file size
    if ($_FILES["scannedImage"]["size"] > 8000000) {
        header("location: ../scanDoc.php?alert=TooLarge");
    }

    // if everything is ok, try to upload file
    if (move_uploaded_file($_FILES["scannedImage"]["tmp_name"], $target_dir. $_POST["questionType"] . '_' . $_POST["passTestID"] . "." . $imageFileType )) {
        if($_POST["questionType"] == "math"){
            $result = $test->setPassMathAns($_POST["passTestID"], $_POST["questionType"] . '_' . $_POST["passTestID"] . "." . $imageFileType);
        }else{
            $result = $test->setPassPicsAns($_POST["passTestID"], $_POST["questionType"] . '_' . $_POST["passTestID"] . "." . $imageFileType);
        }
        header("location: ../scanDoc.php?alert=".$result);
    } else {
        header("location: ../scanDoc.php?alert=Error");
    }
}