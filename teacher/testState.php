<?php
require_once "../Controllers/TestGradingController.php";
$test = new TestGradingController();
$conn = (new Database())->getConnection();

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

if (!isset($_GET["test"])){
    header("location: index.php");
}
$students = $test->getStudentsPerTest($_GET["test"]);
$basicInfo = $test->getTestDetails($_GET["test"]);
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
                        <a class="nav-link" href="index.php" tabindex="-1" >Všetky testy</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="addTest.php" tabindex="-1">Nový test</a>
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

    <main class="px-3 pb-5">
        <h1 class="my-4">Test <?php echo $basicInfo["title"];?></h1>
        <div class="container pb-4">
            <a type="button" href="exportPDF.php?test=<?php echo $_GET["test"];?>" class="btn btn-sm btn-primary <?php if($basicInfo["active"] == 1) echo "disabled";?>" id="exportPDF-<?php echo $_GET["test"] ?>">
                Všetky odpovede
            </a>
            <a type="button" onclick="exportToCsv(this)" class="btn btn-sm btn-primary <?php if($basicInfo["active"] == 1) echo "disabled";?>" id="exportCSV-<?php echo $_GET["test"] ?>">
                <i class="bi bi-save"></i>
                CSV
            </a>
        </div>
        <div class="container">
            <table class="table table-sm table-primary">
                <thead>
                <tr>
                    <th class="text-start">Študent</th>
                    <th class="text-start">Aktívny tab</th>
                    <th class="text-start">Stav</th>
                    <th>Opraviť</th>
                    <th class="text-start">Vyhodnotené</th>
                    <th class="text-start">Počet bodov / <?php echo $basicInfo["questionCount"];?></th>
                    <th class="text-start">Percentá</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($students as $student){ ?>
                    <tr>
                        <td class="fs-5 text-start"><?php echo $student["name"] ?></td>
                        <td class="fs-5 text-start">
                            <?php if($student["focus"] == 0){ ?>
                                <i class="bi bi-circle-fill text-danger"></i>
                            <?php }else{ ?>
                                <i class="bi bi-circle-fill text-success"></i>
                            <?php } ?>
                        </td>
                        <td class="fs-5 text-start">
                            <?php if($student["status"] == 0){ ?>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            <?php }else{ ?>
                                <i class="bi bi-record-circle text-primary"></i>
                            <?php } ?>
                        </td>
                        <td class="fs-5">
                            <a type="button" class="btn btn-sm btn-primary <?php if($student["status"] == 1) echo "disabled";?>" href="grading.php?passTestID=<?php echo $student["studentID"]; ?>" id="evaluate-<?php echo $student["studentID"] ?>" >
                                <i class="bi bi-pen"></i>
                                Oprav test
                            </a>
                        </td>
                        <td class="fs-5 text-start ps-5">
                            <?php if($student["graded"] == 0){ ?>
                                <i class="bi bi-exclamation-circle text-primary"></i>
                            <?php }else{ ?>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            <?php } ?>
                        </td>
                        <td class="fs-5 text-start ps-4">
                            <?php echo $student["score"];?>
                        </td>
                        <td class="fs-5 text-start ps-4">
                            <?php echo 100*intval($student["score"])/intval($basicInfo["questionCount"]);?>%
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
        </div>

    </main>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

<script src="../js/javascript.js"></script>
<script>
    setInterval(function() {
        $.ajax({
            url: "../ModelControllers/GradingModelController.php",
            type: "post",
            data: {tabNotification: true, teacher: <?php echo $_SESSION["loggedTeacher"] ?>},
            success: function (data){
                var toastJson = JSON.parse(data);
                jQuery.each(toastJson, function(i, val) {
                    showToast(val["id"], val["name"]);
                });
            }
        });
    }, 2000);

    function showToast(id, studentName){
        var newToast1 = addToast(id, studentName);
        $('#toastContainer').append(newToast1);

        $('#'+id).toast('show');
    }
</script>
</html>
