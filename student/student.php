<?php
require_once "../Controllers/TestController.php";
$test = new TestController();

print_r($test->getTest($_SESSION["testID"]));
session_start();
if(!isset($_SESSION["loggedStudent"])){
    header("location: index.php");
}

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
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    Home
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    Orders
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    Products
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    Customers
                </a>
            </li>
        </ul>
        <hr>
        <a href="../Controllers/logout.php?logout=2" type="button" class="btn btn-danger mb-3">Odovzdať</a>

    </div>
    <div class="p-3 bg-light w-100 test-page overflow-auto ">
        <div class="bg-white paper-shadow">
            <h2 class="py-1">Test číslo <?php echo $_SESSION["testID"]; ?></h2>
            <form>
                <ol id="testContent" class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto text-start align-items-start w-100">
                            <div class="fw-bold">
                                otázka
                            </div>
                            <div class="py-2">
                                <label for="example2" >odpoveď:</label>
                                <input type="text" class="form-control" id="example2" aria-describedby="odpoved">
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto text-start align-items-start w-100">
                            <div class="fw-bold">
                                otázka
                            </div>
                            <div class="py-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Default checkbox
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Checked checkbox
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto text-start align-items-start w-100">
                            <div class="fw-bold">
                                otázka
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
                            <div class="py-2 row">
                                <div class="col-sm-2">
                                    <input type="email" class="form-control form-control-sm" id="colFormLabelSm" placeholder="">
                                </div>
                                <div class="col-sm-5">
                                    <label for="colFormLabelSm" class="col-sm-5 col-form-label col-form-label-sm">title1</label>
                                </div>
                                <div class="col-sm-1">
                                    cislo
                                </div>
                                <div class="col-sm-4">
                                    title2
                                </div>
                            </div>
                        </div>
                    </li>
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
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="../js/buildTest.js"></script>

</html>
