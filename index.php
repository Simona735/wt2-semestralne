<?php
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

        <form id="studentSignInForm" class="mb-1">
            <div class="form-floating">
                <input type="text" class="form-control" id="examCode" placeholder="ABC123" required>
                <label for="examCode">Kód testu</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="Name" placeholder="Ferko" required>
                <label for="Name">Meno</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="Surname" placeholder="Mrkvička" required>
                <label for="Surname">Priezvisko</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="StudentID" placeholder="12345" required>
                <label for="StudentID">Identifikačné číslo</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Prejdi na test</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2021 - WEBTECH2</p>
        </form>

        <form id="teacherSignInForm" class="mb-1">
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox my-3">
                <label>
                    <input type="checkbox" value="remember-me"> Zapamataj si ma
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Prihlásiť</button>
            <p>Ak nemáš účet, prosím <a href="#" class="link-secondary">registruj sa</a>.</p>
            <p class="mt-5 mb-3 text-muted">&copy; 2021 - WEBTECH2</p>
        </form>

    </main>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>
</html>

