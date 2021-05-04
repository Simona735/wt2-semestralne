
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/primary.css" rel="stylesheet">
</head>
<body class="text-center bg-white">
<div class="container m-5">
    <math-field id="formula" class="math-style" virtual-keyboard-mode="onfocus">f(x)</math-field>

    <math-field id="formula2" read-only class="math-style" virtual-keyboard-mode="onfocus" locale="fr">f(x)</math-field>
    <label>Latex</label>

    <textarea class="output" id="latex" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"></textarea>

</div>


</body>
<script src='https://unpkg.com/mathlive/dist/mathlive.min.js'></script>
<script>


    const mf = document.getElementById('formula');

    document.getElementById('formula').addEventListener('input',(ev) => {
        document.getElementById('latex').value = mf.value;
        console.log(ev.target.value);
    });

    document.getElementById('latex').value = mf.value;

    document.getElementById('latex').addEventListener('input', (ev) => {
        mf.setValue(ev.target.value, {suppressChangeNotifications: true});
    });

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>


</html>

