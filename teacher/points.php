<?php
session_start();

if(isset($_COOKIE["remember"])){
    $_SESSION["loggedTeacher"] = $_COOKIE["remember"];
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
    <title>Points</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="index.php" tabindex="-1">Všetky testy</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="addTest.php" tabindex="-1">Nový test</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="notifications.php" tabindex="-1" >Upozornenia</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link active" href="#" aria-current="page" >Bodovanie</a>
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

    <main class="px-3">
        <h1 class="my-4">Bodovanie</h1>
        <div class="card-body text-start mb-4">
            <p class="card-text">V našej Online Exams aplikácii je možné vytvoriť rôzne testy, kde sa bude nachádzať 5 druhov otázok.
                Otázky budú môcť byť nasledovné:
            <ol>
                <li>Otázky s otvorenou krátkou odpoveďou</li>
                <li>Otázky s výberom správnej odpovede</li>
                <li>Párovanie správnych odpovedí</li>
                <li>Odpoveď v podobe obrázku</li>
                <li>Odpoveď napísaním matematického výrazu</li>
            </ol>
            Všetky správne odpovede budú hodnotené 1b, bez rozdielu otázky. V prípade, že študent odpovie zle, záporné body sa udeľovať nebudú.
            </p>
            <h6 class="card-title text-primary">Otázky s otvorenou krátkou odpoveďou</h6>
            <p class="card-text">Body za správnosť týchto odpovedí bude automaticky priraďovať aplikácia,
                v prípade ak by učiteľ s hodntením aplikácie nesúhlasil alebo ak by aplikácia zle vyhodnotila nejakú
                odpoveď, tak učiteľ bude môcť túto otázku prebodovať. Za správnu odpoveď sa udelí študentovi 1b, samozreje
                toto môže ovplyvniť aj učiteľ.
            </p>
            <h6 class="card-title text-primary">Otázky s výberom správnej odpovede</h6>
            <p class="card-text"> Pri otázkach s výberom odpovede, bude správnosť hodnotiť aplikácia. Odpovede sa budú
                zaznačovať do check boxov, takže bude možné zvoliť viac odpovedí, ktoré bude hodnotiť aplikácia.
                Za správne zakliknutie všetkych správych odpovedí sa udelí študentovi 1b.
            </p>
            <h6 class="card-title text-primary">Párovanie správnych odpovedí</h6>
            <p class="card-text"> Pri prárovaní správnych odpovedí bude taktiež hodnotiť pravdivosť aplikácia. Za úlohu bude
                mať študent spojiť otázky so správnou odpovedou. Pokiaľ sa budú hodnoty otázok rovnať hodnotám
                odpovedí, tak aplikácia vyhodnotí odpoveď ako správnu a priradí patričné hodnotenie.
                Študentovi sa udelí bod za správne spárovanie otázky s odpoveďou.
            </p>
            <h6 class="card-title text-primary">Odpoveď v podobe obrázku</h6>
            <p class="card-text"> Pri týchto otázkach bude hodnotiť správnosť odpovede len učiteľ. Pri
                teste sa zobrazí "plátno" spolu s lištou kde si študent bude mať na výbar pomocky s ktorými bude
                kresliť. Tento obrázoksa uloží bude následne ohodnotený učiteľom. V tomto prípade bod udelí len učiteľ.
            </p>
            <h6 class="card-title text-primary">Odpoveď napísaním matematického výrazu</h6>
            <p class="card-text"> V tomto prípade bude hodnotiť správnosť odpovede učiteľ. Ak vyhodnotí odpoveď za správnu
                študent dostane 1 bod.
            </p>
        </div>
    </main>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>
