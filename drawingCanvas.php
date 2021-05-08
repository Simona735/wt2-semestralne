
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
    <zwibbler z-controller="MyFunction" showCopyPaste="false" id="picsans">
        <div z-canvas></div>
    </zwibbler>


    <zwibbler z-controller="MyFunction" showCopyPaste="false" id="picsans2">
        <div z-canvas></div>
    </zwibbler>


</div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://zwibbler.com/zwibbler-demo.js"></script>
<script>

    // function MyFunction(ctx) {
    //     ctx.on("document-changed", function (info) {            // event vyvolany po zmene nakreleného obrázka
    //         console.log(ctx.getElement().id);
    //     });
    // }

    Zwibbler.controller("MyFunction", (scope) => {
        let saved = "";
        const ctx = scope.ctx;
        ctx.on("document-changed", function (info) {            // event vyvolany po zmene nakreleného obrázka
            if (ctx.dirty()) {
                let element = ctx.$element;
                saved = ctx.save('svg');                        // ulozenie obrázka do premennej
                // changeInput(element, "picsAns", null, saved);
                console.log("dirty")
            } else {
                console.log("else")
            }
        });
    })


</script>

<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>


</html>

