<?php
require_once "../Controllers/TestGradingController.php";
$test = new TestGradingController();

session_start();

if(isset($_COOKIE["remember"])){
    $_SESSION["loggedTeacher"] = true;
}

if (!isset($_SESSION["loggedTeacher"])) {
    header("location: ../index.php");
}

if (!isset($_GET["test"])){
    header("location: index.php");
}


$students = $test->getAllStudentAnswers($_GET["test"]);

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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js" integrity="sha512-jzL0FvPiDtXef2o2XZJWgaEpVAihqquZT/tT89qCVaxVuHwJ/1DFcJ+8TBMXplSJXE8gLbVAUv+Lj20qHpGx+A==" crossorigin="anonymous"></script>
<!--    <script src='https://unpkg.com/mathlive/dist/mathlive.min.js'></script>-->
</head>
<body class="text-center" >
<div>
    <button id="cmd" class="btn btn-sm btn-primary mt-2"><i class="bi bi-save"></i> generuj PDF</button>
    <div class="cover-container full-page d-flex w-100 h-100 mx-auto flex-column">
        <div class="d-flex flex-row">
            <div  class="p-3 w-100 test-page overflow-auto ">
                <div id="content" class="bg-white paper-shadow">
                    <?php foreach ($students as $student){?>
                        <h2 class="py-1"><?php echo $student["name"] ." - ". $student["idNumber"]; ?></h2>
                        <ol id="testContent" class="list-group list-group-numbered">
                            <?php foreach ($student["questions"] as $question){
                                switch ($question["type"]){
                                    case "short_ans":
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["passQuestionId"];?>">
                                            <div class="ms-2 me-auto text-start align-items-start w-100">
                                                <div class="fw-bold">
                                                    <p><?php echo $question["title"];?></p>
                                                </div>
                                                <div class="py-2">
                                                    <output><?php echo $question["short_ans"];?></output>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                        break;
                                    case "more_ans":
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["passQuestionId"];?>">
                                            <div class="ms-2 me-auto text-start align-items-start w-100">
                                                <div class="fw-bold">
                                                    <p><?php echo $question["title"];?></p>
                                                </div>
                                                <div class="py-2">
                                                    <?php foreach ($question["more_ans"] as $answer){?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="moreans-<?php echo $answer["moreID"];?>" <?php echo $answer["my_ans"] == 1 ? "checked" : "";?> disabled>
                                                            <label class="form-check-label" for="moreans-<?php echo $answer["moreID"];?>">
                                                                <?php echo $answer["optionTitle"];?>
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
                                        <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["passQuestionId"];?>">
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
                                                </div>
                                                <?php $i = 0; foreach ($question["pair_ans"] as $answer){ $i++;?>
                                                    <div class="py-2 row">
                                                        <div class="col-sm-5">
                                                            <output><?php echo $answer["my_left"];?></output>
                                                        </div>
                                                        <div class="col-sm-4" >
                                                            <output><?php echo $answer["my_right"];?></output>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </li>
                                        <?php
                                        break;
                                    case "math_ans":
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["passQuestionId"];?>">
                                            <div class="ms-2 me-3 text-start align-items-start w-100">
                                                <div class="fw-bold">
                                                    <p><?php echo $question["title"];?></p>
                                                </div>
                                                <div class="py-2">
                                                    <?php if($question["math_ans"]["type"] == "editor"){?>
                                                        <math-field read-only id="mathans-<?php echo $question["math_ans"]["pass_id"];?>" class="math-style" virtual-keyboard-mode="off"><?php echo $question["math_ans"]["value"];?></math-field>
                                                    <?php }else if($question["math_ans"]["type"] == "scanned") {?>
                                                        <img src="<?php echo $question["math_ans"]["value"];?>" onclick="showModal('<?php echo $question["math_ans"]["value"];?>')" alt="image answer" height="300px">
                                                    <?php }else{?>
                                                        <p>-</p>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </li>

                                        <?php
                                        break;
                                    case "pics_ans":
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start" id="<?php echo $question["passQuestionId"];?>">
                                            <div class="ms-2 me-3 text-start align-items-start w-100">
                                                <div class="fw-bold">
                                                    <p><?php echo $question["title"];?></p>
                                                </div>
                                                <div class="py-2">
                                                    <?php if($question["pics_ans"]["value"] == null){?>
                                                        <p>-</p>
                                                    <?php }else{?>
                                                        <img src="<?php echo $question["pics_ans"]["value"];?>" alt="image answer" height="300px">
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </li>

                                        <?php break;
                                }
                            }; ?>
                        </ol>
                    <?php }?>
                </div>

            </div>
        </div>
</div>


</div>
<script>

    function addScript(url) {
        var script = document.createElement('script');
        script.type = 'application/javascript';
        script.src = url;
        document.head.appendChild(script);
    }
    addScript('https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js');

    $('#cmd').click(function () {

        var w = document.getElementById("content").offsetWidth;
        var h = document.getElementById("content").offsetHeight;

        var opt = {
            margin: 0.5,
            filename: 'test export.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 3 },
            jsPDF: { unit: 'pt', format: [w,h], orientation: 'p' }
        };

        html2pdf().set(opt).from($('#content').html()).save();

    });
</script>
</body>
</html>
