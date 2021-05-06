<?php
require_once "../Controllers/CreateTestController.php";
$testBuilder = new BuildTestController();
$conn = (new Database())->getConnection();

// delete no correct close test builder
$deleteTest = $conn->prepare("select ID from test where test_code = 0");
$deleteTest->execute();
while ($row = $deleteTest->fetch(PDO::FETCH_ASSOC)) {
    $deleteQuestion = $conn->prepare("select ID from question where test_id = :test_id");
    $deleteQuestion->bindValue("test_id", $row["ID"]);
    $deleteQuestion->execute();
    while ($rowq = $deleteQuestion->fetch(PDO::FETCH_ASSOC)) {
        $testBuilder->deleteQuestion($rowq["ID"]);
    }
    $deleteTestWorker = $conn->prepare("delete from test where ID = :test_ID");
    $deleteTestWorker->bindValue("test_ID", $row["ID"]);
    $deleteTestWorker->execute();
}
session_start();

if(isset($_COOKIE["remember"])){
    $_SESSION["loggedTeacher"] = $_COOKIE["remember"];
}

if (!isset($_SESSION["loggedTeacher"])) {
    header("location: ../index.php");
}

$stmt = $conn->query("SELECT * FROM `test` WHERE teacher_ID =". $_SESSION["loggedTeacher"]);
$all = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    array_push($all,[$row["ID"],$row["title"],$row["duration"],$row["activation"], $row["test_code"]]);
}

?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All tests</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item me-2">
                        <a class="nav-link active" aria-current="page" href="#" tabindex="-1" >Všetky testy</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="addTest.php" tabindex="-1">Nový test</a>
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

    <main class="px-3">
        <h1 class="my-4">Všetky testy</h1>
        <div class="container">
            <table class="table table-sm table-primary">
                <thead>
                <tr>
                    <th scope="col" class="text-start">Názov</th>
                    <th scope="col" class="text-start">Kód testu</th>
                    <th scope="col" class="text-start">Trvanie testu</th>
                    <th scope="col" class="text-start">Aktívny</th>
                    <th scope="col" class="text-start">Stav</th>
                    <th scope="col" class="text-start">Opraviť</th>
                    <th scope="col" class="text-start">Export</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($all as $info){ ?>
                    <tr>
                        <td class="test-title text-start"><?php echo $info[1] ?></td>
                        <td class="text-start" ><span class="badge bg-code fs-5"><?php echo $info[4] ?></span></td>
                        <td class="fs-5 text-start"><?php echo $info[2] ?></td>
                        <td class="fs-5">
                            <div class="form-check form-switch">
                                <input class="form-check-input" onchange="switchActive('<?php echo $info[0] ?>')" type="checkbox" id="switch-<?php echo $info[0] ?>" <?php if($info[3] == 1) echo "checked";?>>
                                <label class="form-check-label" for="switch-<?php echo $info[0] ?>"></label>
                            </div>
                        </td>
                        <td class="fs-5 text-start">
                            <a type="button" class="btn btn-sm btn-primary" href="testState.php?test=<?php echo $info[0] ?>">
                                <i class="bi bi-eye"></i>
                                Sleduj stav
                            </a>
                        </td>
                        <td class="fs-5 text-start">
                            <a type="button" class="btn btn-sm btn-primary <?php if($info[3] == 1) echo "disabled";?>" id="evaluate-<?php echo $info[0] ?>">
                                <i class="bi bi-pen"></i>
                                Oprav test
                            </a>
                        </td>
                        <td class="fs-5 text-start">
                            <a type="button" class="btn btn-sm btn-primary <?php if($info[3] == 1) echo "disabled";?>" id="export-<?php echo $info[0] ?>">
                                <i class="bi bi-save"></i>
                                PDF
                            </a>
                            <a type="button" class="btn btn-sm btn-primary <?php if($info[3] == 1) echo "disabled";?>" id="export-<?php echo $info[0] ?>">
                                <i class="bi bi-save"></i>
                                CSV
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

<script src="../js/javascript.js"></script>
</html>
