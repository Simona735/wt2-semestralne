document.addEventListener("DOMContentLoaded", () => {
    Zwibbler.controller("mycontroller", (scope) => {
        let saved = "";
        const ctx = scope.ctx;
        ctx.on("document-changed", function (info) {            // event vyvolany po zmene nakreleného obrázka
            if (ctx.dirty()) {
                let element = ctx.$element;
                saved = ctx.save('svg');                        // ulozenie obrázka do premennej
                changeInput(element, "drawAns", null, saved);
                console.log("dirty")
            } else {
                console.log("else")
            }
        });
    })
})
