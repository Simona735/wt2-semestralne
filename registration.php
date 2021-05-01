<?php
require_once "Controllers/LoginController.php";
session_start();

$register = new LoginController();

if (isset($_SESSION["loggedTeacher"]) || isset($_COOKIE["remember"])){
    header("location: teacher/index.php");
}

if(isset($_SESSION["loggedStudent"])){
    header("location: student.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $register->registerTeacher($_POST["name"], $_POST["surname"], $_POST["floatingInput"], $_POST["floatingPassword"]);
}
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrácia</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="text-center bg-light">

<div class="cover-container pt-5 d-flex mx-auto flex-column">
    <main role="main" class="m-auto w-25">
        <img class="mb-4" src="img/to%20do%20icon.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Exam portal</h1>

        <form id="teacherRegisterForm" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" class="mb-1">
            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ferko" required>
                <label for="name">Meno</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Mrkvička" required>
                <label for="surname">Priezvisko</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" name="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Registruj sa</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2021 - WEBTECH2</p>
        </form>

    </main>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>
</html>