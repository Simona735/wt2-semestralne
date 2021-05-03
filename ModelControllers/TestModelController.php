<?php
require_once "../Controllers/TestController.php";
$test = new TestController();

//var_dump($test->getTest());

if(isset($_POST["activeState"]) && isset($_POST["testId"])){
    $test->setActivation($_POST["activeState"], $_POST["testId"]);
}
