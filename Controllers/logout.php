<?php
session_start();

if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    setcookie("remember", "", time() - 3600);
    session_destroy();
    header("location: ../index.php");
}

if (isset($_GET["logout"]) && $_GET["logout"] == 2) {
    setcookie("remember", "", time() - 3600);
    session_destroy();
    header("location: ../index.php");
}