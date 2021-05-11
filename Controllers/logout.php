<?php
require_once "TestController.php";
$test = new TestController();
session_start();

if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    setcookie("remember", "", time() - 18000, '/exam');
    session_destroy();
    header("location: ../index.php");
}

if (isset($_GET["logout"]) && $_GET["logout"] == 2) {
    $test->setStatus($_SESSION["passTestId"], 0);
    setcookie("student", "", time() - 18000, '/exam');
    session_unset();
    session_destroy();
    header("location: ../index.php");
}