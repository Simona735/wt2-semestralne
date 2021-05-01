<?php
require_once "Controllers/LoginController.php";
$login = new LoginController();
session_start();

if (isset($_SESSION["loggedTeacher"]) || isset($_COOKIE["remember"])) {
    header("location: teacher/index.php");
}

if (isset($_SESSION["loggedStudent"])) {
    header("location: student.php");
}

$action = isset($_POST['action']) ? $_POST['action'] : null;
switch ($action) {
    case 'loginStudent':
        $login->loginStudent($_POST["examCode"], $_POST["Name"], $_POST["Surname"], $_POST["StudentID"]);
        break;
    case 'loginTeacher':
        if (isset($_POST["remember-me"])) {
            $login->loginTeacher($_POST["teacherEmail"], $_POST["teacherPassword"], $_POST["remember-me"]);
        } else {
            $login->loginTeacher($_POST["teacherEmail"], $_POST["teacherPassword"], 0);
        }
        break;
}

?>


<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/primary.css" rel="stylesheet">
</head>
<body class="text-center bg-light">
<div class="cover-container pt-5 d-flex mx-auto flex-column">
    <main role="main" class="m-auto w-25">
        <img class="mb-4" src="img/to%20do%20icon.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Exam portal</h1>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="studentButton" href="#">Študent</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="teacherButton" href="#">Učiteľ</a>
            </li>
        </ul>

        <form id="studentSignInForm" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" class="mb-1">
            <div class="form-floating">
                <input type="text" class="form-control" id="examCode" name="examCode" placeholder="ABC123" required>
                <label for="examCode">Kód testu</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="Name" name="Name" placeholder="Ferko" required>
                <label for="Name">Meno</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="Surname" name="Surname" placeholder="Mrkvička" required>
                <label for="Surname">Priezvisko</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="StudentID" name="StudentID" placeholder="12345" required>
                <label for="StudentID">Identifikačné číslo</label>
            </div>
            <input type="hidden" name="action" value="loginStudent">
            <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Prejdi na test</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2021 - WEBTECH2</p>
        </form>

        <form id="teacherSignInForm" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" class="mb-1">
            <div class="form-floating">
                <input type="email" class="form-control" id="teacherEmail" name="teacherEmail" placeholder="name@example.com">
                <label for="teacherEmail">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="teacherPassword" name="teacherPassword" placeholder="Password">
                <label for="teacherPassword">Password</label>
            </div>

            <div class="checkbox my-3">
                <label>
                    <input type="checkbox" name="remember-me" value="remember-me"> Zapamataj si ma
                </label>
            </div>
            <input type="hidden" name="action" value="loginTeacher">
            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Prihlásiť</button>
            <p>Ak nemáš účet, prosím <a href="registration.php" class="link-secondary">registruj sa</a>.</p>
            <p class="mt-5 mb-3 text-muted">&copy; 2021 - WEBTECH2</p>
        </form>

    </main>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>
</html>

