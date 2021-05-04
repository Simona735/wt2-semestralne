<?php
require_once "../Controllers/CreateTestController.php";
$addTest = new AddTestController();
session_start();

if(isset($_COOKIE["remember"])){
    $_SESSION["loggedTeacher"] = $_COOKIE["remember"];
}

if (!isset($_SESSION["loggedTeacher"])) {
    header("location: ../index.php");
}

if (isset($_POST["title"]) and isset($_POST["duration"])) {
    $title = $_POST["title"];
    $duration = $_POST["duration"];
    $addTest->addTest($title,$duration);
}


?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New test</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Custom styles for this template -->
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/primary.css" rel="stylesheet">
    <link rel="icon" href="../img/to%20do%20icon.png" type="image/png" sizes="16x16">
</head>
<body class="text-center">
    <div class="cover-container full-page d-flex w-100 h-100 mx-auto flex-column">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Fourth navbar example">
            <div class="container-fluid">

                <a class="navbar-brand me-5" href="#">
                    <img class="ms-5 me-2 mb-1" src="../img/to%20do%20icon.png" alt="" width="30" height="30">
                    <span class="fs-4">Exam</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample04">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item me-2">
                            <a class="nav-link" href="#">Domov</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link active" aria-current="page" href="addTest.php" tabindex="-1">Nový test</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link" href="allTests.php" tabindex="-1" >Všetky testy</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link" href="notifications.php" tabindex="-1" >Upozornenia</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link" href="points.php" tabindex="-1" >Bodovanie</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-bs-toggle="dropdown" aria-expanded="false">Prehľad</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown04">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../img/user%20icon.svg" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="profile.php">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="../Controllers/logout.php?logout=1">Odhlásiť sa</a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

        <main class="row align-items-center justify-content-center w-100 h-100">
            <div class="col-md-6">
                <h3 class="g-3">Pridaj nový test</h3>
                <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Názov testu</label>
                        <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Trvanie</label>
                        <input type="time" name="duration" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary">Vytvoriť</button>
                </form>
            </div>
        </main>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="../js/questionsCreate.js"></script>


</html>
