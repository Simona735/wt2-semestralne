<?php

$location = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$location .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];



?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/primary.css" rel="stylesheet">
</head>
<body class="text-center bg-light">
<div class="container mt-5">
    <ol class="list-group list-group-numbered ">
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-3 text-start align-items-start w-100">
                <div class="fw-bold">
                    <label for="example1" >otazka:</label>
                    <input type="text" class="form-control" id="example1" aria-describedby="otazka">
                </div>
                <div class="py-2">
                    <math-field id="formula" class="math-style" virtual-keyboard-mode="onfocus">f(x)</math-field>
                </div>
            </div>
            <div class="align-items-start d-flex">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $location;?>" alt="qr" height="150px" width="150px">
                <i data-bs-toggle="tooltip" data-bs-placement="left" title="Pre pridanie dokumentu, naskenuj QR kód" class="tooltipIcon bi bi-info-circle ms-3"></i>
            </div>

        </li>
    </ol>


    <?php echo $location;?>

    <input type="file" accept="image/*" id="file-input" capture="environment">






</div>


</body>

<script src='https://unpkg.com/mathlive/dist/mathlive.min.js'></script>

<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })


        $(document).ready(function () {
        const fileInput = document.getElementById('file-input');


        fileInput.addEventListener('change', (e) => console.log("change"));

    });




</script>
</html>

