<?php
session_start();

if(isset($_COOKIE["remember"])){
    $_SESSION["loggedTeacher"] = true;
}

if (!isset($_SESSION["loggedTeacher"])) {
    header("location: ../index.php");
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

            <a class="navbar-brand me-5" href="index.php">
                <img class="ms-5 me-2 mb-1" src="../img/to%20do%20icon.png" alt="" width="30" height="30">
                <span class="fs-4">Exam</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04"
                    aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="index.php" tabindex="-1">Všetky testy</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link active" aria-current="page" href="#">Nový test</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="points.php" tabindex="-1">Informácie</a>
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

    <div class="d-flex flex-row page-height">
        <div id="studentSidebar" class="text-white bg-dark p-3 d-flex flex-column h-100">
            <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white ">
                <span class="fs-4">Pridaj otázky</span>
            </div>
            <hr>
            <ul class="nav nav-pills  flex-column mb-auto">
                <li class="nav-item questions-list">
                    <a href="#" id="short-question" class="nav-link btn-outline-primary text-white">
                        <i class="bi bi-plus-square-dotted me-1"></i>
                        Krátka odpoveď
                    </a>
                </li>
                <li class="nav-item questions-list">
                    <a href="#" id="multiple-question" class="nav-link btn-outline-primary text-white">
                        <i class="bi bi-plus-square-dotted me-1"></i>
                        Viaceré odpovede
                    </a>
                </li>
                <li class="nav-item questions-list">
                    <a href="#" id="pair-question" class="nav-link btn-outline-primary text-white">
                        <i class="bi bi-plus-square-dotted me-1"></i>
                        Párová otázka
                    </a>
                </li>
                <li class="nav-item questions-list">
                    <a href="#" id="draw-question" class="nav-link btn-outline-primary text-white">
                        <i class="bi bi-plus-square-dotted me-1"></i>
                        Kresliaca otázka
                    </a>
                </li>
                <li class="nav-item questions-list">
                    <a href="#" id="math-question" class="nav-link btn-outline-primary text-white">
                        <i class="bi bi-plus-square-dotted me-1"></i>
                        Matematický výraz
                    </a>
                </li>
            </ul>
            <hr>
            <button type="button" class="btn btn-success mb-2" onclick="submitTest(<?php echo $_GET["testID"]; ?>)">Hotovo</button>

        </div>
        <div class="p-3 bg-light w-100 test-page overflow-auto ">
            <div class="bg-white paper-shadow">
                <h2 class="py-1"><?php echo $_GET["title"]; ?></h2>
                <form>
                    <ol id="testContent" class="list-group list-group-numbered">

                    </ol>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="../js/questionsCreate.js"></script>
<script>var test_ID = <?php echo $_GET["testID"]; ?></script>

</html>
