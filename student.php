<?php
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>

    <!-- Bootstrap core CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/primary.css" rel="stylesheet">
</head>
<body class="text-center">
<div class="d-flex flex-row h-100" >
    <div id="studentSidebar" class="text-white bg-dark p-3 d-flex flex-column h-100">
        <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white ">
            <img src="img/user%20icon.svg" alt="user-pic" width="32" height="32" class="rounded-circle me-3">
            <span class="fs-4">Meno</span>
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
        <button type="button" class="btn btn-danger mb-3">Odovzdať</button>

    </div>
    <div class="p-3 bg-light w-100 test-page">
        <div class="bg-white h-100 paper-shadow">
            <h2 class="py-1">Test číslo xxx</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button>
            <form>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">otazka</div>
                            <div>odpoved</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">otazka</div>
                            <div>odpoved</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">otazka</div>
                            <div>odpoved</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                </ol>
            </form>
        </div>

    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</html>
