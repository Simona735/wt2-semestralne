<?php
session_start();

if(isset($_COOKIE["remember"])){
    $_SESSION["loggedTeacher"] = true;
}

if (!isset($_SESSION["loggedTeacher"])) {
    header("location: ../index.php");
}

if(!isset($_GET["passTestID"])){
    header("location: index.php");
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
                        <a class="nav-link" href="index.php" tabindex="-1" >Všetky testy</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="addTest.php" tabindex="-1">Nový test</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="notifications.php" tabindex="-1" >Upozornenia</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="points.php" tabindex="-1" >Informácie</a>
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
        <div class="p-3 bg-light w-100 test-page overflow-auto ">
            <div class="bg-white paper-shadow">
                <h2 class="py-1">Študent, pass test ID: <?php echo $_GET["passTestID"]; ?></h2>
                <form action="" method="POST">
                    <ol id="testContent" class="list-group list-group-numbered">
                        <input type="hidden" name="passTestID" value="<?php echo $_GET["passTestID"]; ?>">
                        <?php foreach (getTestForGrading($_GET["passTestID"]) as $question){
                            switch ($question["type"]){
                            case "short_ans":
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["ID"];?>">
                                    <div class="ms-2 me-auto text-start align-items-start w-100">
                                        <div class="fw-bold">
                                            <p><?php echo $question["title"];?></p>
                                        </div>
                                        <div class="py-2">
                                            <output><?php echo $question["short_ans"]["my_ans"];?></output>
                                        </div>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <h4><span class="badge bg-primary">body</span></h4>
                                        <h4><span class="badge bg-secondary">body</span></h4>
                                    </div>
                                </li>
                            <?php
                            break;
                            case "more_ans":
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["ID"];?>">
                                    <div class="ms-2 me-auto text-start align-items-start w-100">
                                        <div class="fw-bold">
                                            <p><?php echo $question["title"];?></p>
                                        </div>
                                        <div class="py-2">
                                            <?php foreach ($question["more_ans"] as $answer){?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="moreans-<?php echo $answer["pass_id"];?>" disabled >
                                                    <label class="form-check-label" for="moreans-<?php echo $answer["pass_id"];?>">
                                                        <?php echo $answer["title"];?>
                                                    </label>
                                                </div>
                                            <?php };?>
                                        </div>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <h4><span class="badge bg-primary">body</span></h4>
                                        <h4><span class="badge bg-secondary">body</span></h4>
                                    </div>
                                </li>
                            <?php
                            break;
                            case "pair_ans":
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["ID"];?>">
                                    <div class="ms-2 me-auto text-start align-items-start w-100">
                                        <div class="fw-bold">
                                            <p><?php echo $question["title"];?></p>
                                        </div>
                                        <div class="py-2 row">
                                            <div class="col-sm-5">
                                                <span class="text-decoration-underline">lavý stĺpec</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="text-decoration-underline">pravý stĺpec</span>
                                            </div>
                                            <div class="col-sm-1">
                                                <span class="text-decoration-underline">check</span>
                                            </div>
                                        </div>
                                        <?php $i = 0; foreach ($question["pair_ans"] as $answer){ $i++;?>
                                            <div class="py-2 row">
                                                <div class="col-sm-5">
                                                    <output><?php echo $answer["left_part"];?></output>
                                                </div>
                                                <div class="col-sm-4" >
                                                    <output><?php echo $answer["right_part"];?></output>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <h4><span class="badge bg-primary">body</span></h4>
                                        <h4><span class="badge bg-secondary">body</span></h4>
                                    </div>
                                </li>
                            <?php
                            break;
                            case "math_ans":
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["ID"];?>">
                                    <div class="ms-2 me-3 text-start align-items-start w-100">
                                        <div class="fw-bold">
                                            <p><?php echo $question["title"];?></p>
                                        </div>
                                        <div class="py-2">
                                            <math-field read-only id="mathans-<?php echo $question["math_ans"]["pass_id"];?>" class="math-style" virtual-keyboard-mode="off"></math-field>
                                            <img src="<?php echo $question["path"];?>" alt="image answer" height="200px" width="200px">
                                        </div>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <input class="form-check-input" type="checkbox" value="" id="mathans-<?php echo $question["math_ans"]["pass_id"];?>">
                                        <label class="form-check-label" for="mathans-<?php echo $question["math_ans"]["pass_id"];?>">
                                            správne
                                        </label>
                                    </div>
                                </li>

                            <?php
                            break;
                            case "pics_ans":
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["ID"];?>">
                                    <div class="ms-2 me-3 text-start align-items-start w-100">
                                        <div class="fw-bold">
                                            <p><?php echo $question["title"];?></p>
                                        </div>
                                        <div class="py-2">
                                            <img src="<?php echo $question["path"];?>" alt="image answer" height="200px" width="200px">
                                        </div>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <input class="form-check-input" type="checkbox" value="" id="picsans-<?php echo $question["pics_ans"]["pass_id"];?>">
                                        <label class="form-check-label" for="picsans-<?php echo $question["pics_ans"]["pass_id"];?>">
                                            správne
                                        </label>
                                    </div>
                                </li>

                                <?php break;
                            }
                        }; ?>
                    </ol>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>


</body>
<script src='https://unpkg.com/mathlive/dist/mathlive.min.js'></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://zwibbler.com/zwibbler-demo.js"></script>
</html>
