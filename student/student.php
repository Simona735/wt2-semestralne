<?php
session_start();
if(!isset($_COOKIE["student"])){
    header("location: ../index.php");

}

if($_COOKIE["student"] == "smith"){
    header("location: ../index.php");

}

if(!isset($_SESSION["loggedStudent"])){
    header("location: ../index.php");
}

require_once "../Controllers/TestController.php";
require_once "../db connection/Database.php";

$conn = (new Database())->getConnection();
$test = new TestController();

$location = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$location .= $_SERVER["SERVER_NAME"];// . $_SERVER["REQUEST_URI"];


$questions = $test->getTest($_SESSION["testID"]);


?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>

    <!-- Bootstrap core CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Custom styles for this template -->
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/primary.css" rel="stylesheet">
    <link rel="icon" href="../img/to%20do%20icon.png" type="image/png" sizes="16x16">

</head>
<body class="text-center">
<div class="d-flex flex-row h-100" >
    <div id="studentSidebar" class="text-white bg-dark p-3 d-flex flex-column h-100">
        <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white ">
            <img src="../img/user%20icon.svg" alt="user-pic" width="32" height="32" class="rounded-circle me-3">
            <span class="fs-4"><?php echo $_SESSION["name"] ?></span>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">

        </ul>
        <div>
            <p>Čas do konca testu</p>
            <div id="timer" class="fs-1">
            </div>
        </div>
        <hr>
        <a href="../Controllers/logout.php?logout=2" id="submitButton" type="button" class="btn btn-danger mb-3">Odovzdať</a>

    </div>
    <div class="p-3 bg-light w-100 test-page overflow-auto ">
        <div class="bg-white paper-shadow">
            <h2 class="py-1">Test číslo <?php echo $_SESSION["testID"]; ?></h2>
            <form>
                <ol id="testContent" class="list-group list-group-numbered">
                    <?php foreach ($questions as $question){
                        switch ($question["type"]){
                            case "short_ans":
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["ID"];?>">
                                    <div class="ms-2 me-auto text-start align-items-start w-100">
                                        <div class="fw-bold">
                                            <p><?php echo $question["title"];?></p>
                                        </div>
                                        <div class="py-2">
                                            <label for="shortans-<?php echo $question["short_ans"]["pass_id"];?>" >odpoveď:</label>
                                            <input type="text" class="form-control" id="shortans-<?php echo $question["short_ans"]["pass_id"];?>" aria-describedby="odpoved" onchange="changeInput(this, 'shortAns')">
                                        </div>
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
                                            <div class="form-check" id="<?php echo $answer["ID"];?>">
                                                <input class="form-check-input" type="checkbox" value="" id="moreans-<?php echo $answer["pass_id"];?>"  onchange="changeInput(this, 'moreAns')">
                                                <label class="form-check-label" for="moreans-<?php echo $answer["pass_id"];?>">
                                                    <?php echo $answer["title"];?>
                                                </label>
                                            </div>
                                            <?php };?>
                                        </div>
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
                                            <div class="col-sm-2">
                                                <span class="text-decoration-underline">index pravého stĺpca</span>
                                            </div>
                                            <div class="col-sm-5">
                                                <span class="text-decoration-underline">lavý stĺpec</span>
                                            </div>
                                            <div class="col-sm-1">
                                                <span class="text-decoration-underline">index</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="text-decoration-underline">pravý stĺpec</span>
                                            </div>
                                        </div>
                                        <?php $i = 0; foreach ($question["pair_ans"] as $answer){ $i++;?>
                                        <div class="py-2 row" id="<?php echo $answer["ID"];?>">
                                            <div class="col-sm-2">
                                                <input type="number" min="1" class="form-control form-control-sm" id="pairans-<?php echo $answer["pass_id"];?>" placeholder="" onchange="changeInput(this, 'pairAns', '<?php echo $answer["left_part"];?>', null, '<?php echo $question["ID"];?>')">
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="pairans-<?php echo $answer["pass_id"];?>" class="col-sm-5 col-form-label col-form-label-sm"><?php echo $answer["left_part"];?></label>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $i;?>
                                            </div>
                                            <div class="col-sm-4" id="pairright-<?php echo $question["ID"]."-".$i;?>">
                                                <p><?php echo $answer["right_part"];?></p>
                                            </div>
                                        </div>
                                        <?php }?>
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
                                            <math-field id="mathans-<?php echo $question["math_ans"]["pass_id"];?>" class="math-style" virtual-keyboard-mode="onfocus" onchange="changeInput(this, 'mathAns')"></math-field>
                                            <button type="button" class="btn btn-outline-danger d-none" onclick="deleteScannedImg('math','<?php echo $question["math_ans"]["pass_id"];?>')" id="mathBtn-<?php echo $question["math_ans"]["pass_id"];?>">
                                                <i class="bi bi-x"></i>
                                                Vymaž naskenovaný obrázok
                                            </button>
                                        </div>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $location;?>/exam/scanDoc.php?data=math_<?php echo $question["math_ans"]["pass_id"];?>" alt="qr" height="120px" width="120px">
                                        <i data-bs-toggle="tooltip" data-bs-placement="left" title="Pre pridanie dokumentu, naskenuj QR kód" class="tooltipIcon bi bi-info-circle ms-3"></i>
                                    </div>
                                </li>
                                <script>
                                    setInterval(function() {
                                        $.ajax({
                                            url: "../ModelControllers/TestModelController.php",
                                            type: "post",
                                            data: {imageType: "math", passId: <?php echo $question["math_ans"]["pass_id"] ?>},
                                            success: function (result){
                                                if (result !== '"null"'){
                                                    document.getElementById("mathans-<?php echo $question["math_ans"]["pass_id"];?>").value = '';
                                                    document.getElementById("mathans-<?php echo $question["math_ans"]["pass_id"];?>").style.display = "none";
                                                    document.getElementById("mathBtn-<?php echo $question["math_ans"]["pass_id"];?>").classList.remove("d-none");
                                                }
                                            }
                                        });
                                    }, 3000);
                                </script>
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
                                            <zwibbler z-controller="mycontroller" showCopyPaste="false" id="picsans-<?php echo $question["pics_ans"]["pass_id"];?>">
                                                <div z-canvas></div>
                                            </zwibbler>
                                            <button type="button" class="btn btn-outline-danger d-none" onclick="deleteScannedImg('pics','<?php echo $question["pics_ans"]["pass_id"];?>')" id="picsBtn-<?php echo $question["pics_ans"]["pass_id"];?>">
                                                <i class="bi bi-x"></i>
                                                Vymaž naskenovaný obrázok
                                            </button>
                                        </div>
                                    </div>
                                    <div class="align-items-start d-flex">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $location;?>/exam/scanDoc.php?data=pics_<?php echo $question["pics_ans"]["pass_id"];?>" alt="qr" height="120px" width="120px">
                                        <i data-bs-toggle="tooltip" data-bs-placement="left" title="Pre pridanie dokumentu, naskenuj QR kód" class="tooltipIcon bi bi-info-circle ms-3"></i>
                                    </div>
                                </li>
                            <script>
                                setInterval(function() {
                                    $.ajax({
                                        url: "../ModelControllers/TestModelController.php",
                                        type: "post",
                                        data: {imageType: "pics", passId: <?php echo $question["pics_ans"]["pass_id"] ?>},
                                        success: function (result){
                                            if (result !== '"null"'){
                                                document.getElementById("picsans-<?php echo $question["pics_ans"]["pass_id"];?>").style.display = "none";
                                                document.getElementById("picsBtn-<?php echo $question["pics_ans"]["pass_id"];?>").classList.remove("d-none");
                                            }
                                        }
                                    });
                                }, 3000);
                            </script>
                                <?php break;
                        }
                    }; ?>
                </ol>
            </form>
        </div>

    </div>
</div>



<div class="modal fade" id="startModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalLabel">Test je pripravený</h5>
                <p>Nesmieš opustit okno, inak bude tvoj vyučujúci upozornený.</p>
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Začať písať test</button>
            </div>
        </div>
    </div>
</div>

</body>
<script src='https://unpkg.com/mathlive/dist/mathlive.min.js'></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://zwibbler.com/zwibbler-demo.js"></script>
<script src="../js/drawing.js"></script>
<script src="../js/fillTest.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    })
</script>
<script>

    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.append(newNode);
    }

    function deleteScannedImg(type, passId){
        $.ajax({
            url: "../ModelControllers/TestModelController.php",
            type: "post",
            data: {deletePic: passId, picType: type},
            success: function (){
                document.getElementById(type+"ans-"+passId).style.display = "block";
                document.getElementById(type+"Btn-"+passId).classList.add("d-none");
                zwibblers["picsans-"+passId].newDocument();
            }
        });
    }

    document.addEventListener("visibilitychange", function() {
        $.ajax({
            url: "../ModelControllers/TestModelController.php",
            type: "post",
            data: {tabFocus: document.hidden?"0":"1", pass_test: <?php echo $_SESSION["passTestId"] ?>}
        });
    }, false);

    setInterval(function() {
        $.get("../ModelControllers/TestModelController.php",
            {timer: <?php echo $_SESSION["passTestId"] ?>},
            function(data){
                if (!data.slice(1, 9).localeCompare("finished")){
                    document.getElementById("submitButton").click();
                }else{
                    document.getElementById("timer").innerHTML = data.slice(1, 9);
                }
            });
    }, 1000);
</script>
</html>


