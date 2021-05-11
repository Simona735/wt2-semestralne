function changeInput(element, type, left_pair = null, imageToSave = null, q_ID = null){
    switch (type){
        case "shortAns":
            console.log($(element));
            $.post( "../ModelControllers/TestModelController.php", { update_AValue: "shortAns", SA_ID: $(element).attr('id'), SA_ans:$(element).val()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "moreAns":
            console.log($(element));
            $.post( "../ModelControllers/TestModelController.php", { update_AValue: "moreAns", MA_ID: $(element).attr('id'), MA_ans:$(element).is(':checked')})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "pairAns":
            console.log($(element));
            console.log(left_pair);
            $.post( "../ModelControllers/TestModelController.php", { update_AValue: "pairAns", PA_ID: $(element).attr('id'), PAL_ans:left_pair,  PAR_ans:$("#pairright-"+q_ID+"-"+$(element).val()).children().text()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "mathAns":
            console.log($(element));
            $.post( "../ModelControllers/TestModelController.php", { update_AValue: "mathAns", MT_ID: $(element).attr('id'), MT_ans: $(element).val()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "picsAns":
            console.log($(element));
            $.post( "../ModelControllers/TestModelController.php", { update_AValue: "picsAns", CA_ID: $(element).attr('id'), CA_ans: imageToSave})
                .done(function( data ) {
                    console.log(data);
                });
            break;

    }
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/exam";
}

window.addEventListener("beforeunload", function(event) {
    setCookie("student", "smith", -20);
    document.getElementById("submitButton").click();
     $.get("../Controllers/logout.php?logout=2");
});

