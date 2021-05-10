<?php
require_once "../Controllers/TestController.php";
$test = new TestController();

date_default_timezone_set("Europe/Bratislava");


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
            $id = explode("-", $_POST["CA_ID"])[1];
            $result = $test->updateDrawAns($id, $_POST["CA_ans"]);
            echo json_encode($result);
            break;
        case "mathAns":
            $id = explode("-", $_POST["MT_ID"])[1];
            $result = $test->setPassMathAns($id, $_POST["MT_ans"]);
            echo json_encode($result);
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

    if(isset($_GET["timer"])) {
        $timer = $test->getTimer($_GET["timer"]);
        $a = time() - strtotime($timer["ZaciatokTestu"]);       //kolko pisem test
        $b = strtotime($timer["CelkovyCasNaTest"]) - strtotime(substr($timer["ZaciatokTestu"], 0, 10) . "00:00:00"); //duration testu

//    echo json_encode($timer);

    if ($a >= $b) {
        session_unset();
        session_destroy();
        echo json_encode("finished");

    }else{
        echo json_encode(date('H:i:s', $b - $a - 3600));
    }

}

if(isset($_POST["tabFocus"]) && isset($_POST["pass_test"])){
    $result = $test->setFocus($_POST["pass_test"], $_POST["tabFocus"]);
    $test->insertNotification($_POST["pass_test"]);
    echo json_encode($result);
}

if(isset($_POST["imageType"]) && isset($_POST["passId"])){
    $images = glob("../img/scannedAnswers/".$_POST["imageType"].'Ans_'.$_POST["passId"].".*");
    if(count($images) == 1){
        if($_POST["imageType"] == "math"){
            $result = $test->setPassMathAns($_POST["passId"], $images[0]);
        } else {
            $result = $test->setPassPicsAns($_POST["passId"], $images[0]);
        }
        echo json_encode(basename($images[0]));
    } else {
        echo json_encode("null");
    }
}

if(isset($_POST["deletePic"]) && isset($_POST["picType"])){
    if($_POST["picType"] == "math"){
        $result = $test->setPassMathAns($_POST["deletePic"], null);
    }else{
        $result = $test->setPassPicsAns($_POST["deletePic"], null);
    }
    $images = glob("../img/scannedAnswers/".$_POST["picType"].'Ans_'.$_POST["deletePic"].".*");

    if(count($images) == 1){
        unlink($images[0]);
        echo json_encode("success");
    }else{
        echo json_encode("empty");
    }
}

