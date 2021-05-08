var zwibblers = [];

function mycontroller(ctx) {
    let saved = "";
    ctx.on("document-changed", function (info) {            // event vyvolany po zmene nakreleného obrázka
        if (ctx.dirty()) {
            let element = ctx.$element;
            saved = ctx.save('svg');
            zwibblers[$(element).attr('id')] = ctx;
            // ulozenie obrázka do premennej
            changeInput(element, "picsAns", null, saved);
            console.log(saved);
        } else {
            console.log("else");
        }
    });
}