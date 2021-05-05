<?php
session_start();

if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    setcookie("remember", "", time() - 18000, '/exam');
    session_destroy();
    header("location: ../index.php");
}

if (isset($_GET["logout"]) && $_GET["logout"] == 2) {
    setcookie("remember", "", time() - 18000, '/exam');
    session_destroy();
    header("location: ../index.php");
}