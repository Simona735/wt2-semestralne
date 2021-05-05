<?php

$location = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$location .= $_SERVER["SERVER_NAME"]; //* . $_SERVER["REQUEST_URI"];

if(isset($_POST["passTestID"])){
    echo "sent";
}

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
<div class="container h-100 ">
    <?php echo $location; ?>
    <h2 class="pt-5">Klikni nižšie pre naskenovanie obrázka</h2>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <input type="hidden" name="passTestID" value="2">
        <input type="hidden" name="passQuestion" value="3">
        <div class="m-5 px-5">
            <input class="d-none" type="file" accept="image/*" onchange="submit()" id="formFile" capture="environment">
            <label for="formFile" class="inputLabel px-4">
                <figure>
                    <img src="img/scanWork.png" alt="qr" height="70px" width="70px">
                </figure>
                <span>Scan file</span>
            </label>
        </div>
    </form>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>

</html>

