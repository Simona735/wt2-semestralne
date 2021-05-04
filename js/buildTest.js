var data = [];

$(document).ready(function () {
    // $("#startModal").modal("toggle");
    //
    // $('#startModal').on('hidden.bs.modal', function () {
    //
    //     // set time
    //
    //     // call some PHP
    //
    //     // get result as "data"
    //
    //     buildTest(data);  //<----- tam pojdu data o teste, potom vymazat hore premennu
    // })
});

function buildTest(data){
    let formBody = $( "#testContent");
    jQuery.each(data, function() {
        switch(data.type) {
            case "short_ans":
                formBody.append(buildShort(data));
                break;
            case "more_ans":
                formBody.append(buildMore(data));
                break;
            case "pair_ans":
                formBody.append(buildPair(data));
                break;
            case "pics_ans":
                // add
                break;
            case "math_ans":
                formBody.append(buildMath(data));
                break;
            default:
            // you fucked up
        };
    });
}

function buildShort(data){
    let answerField = answerFieldShort(data.question);                      // <------ question data
    return createQuestionWrapper(data.id, data.title, answerField )
}

function buildMore(data){
    let answerField = answerFieldMore(data.question);                       // <------ question data
    return createQuestionWrapper(data.id, data.title, answerField )
}

function buildPair(data){
    let answerField = "";       //create answer field
    return createQuestionWrapper(data.id, data.title, answerField )
}

function buildPics(data){
    // will be
}

function buildMath(data){
    let answerField = answerFieldMath(data.question);                      // <------ question data
    return createQuestionWrapper(data.id, data.title, answerField )
}

function createQuestionWrapper(id, title , answerField){
    let li = document.createElement("li");
    li.classList.add("list-group-item");
    li.classList.add("d-flex");
    li.classList.add("justify-content-between");
    li.classList.add("align-items-start");
    li.setAttribute("id", id);                              // <--- tu je ID otazky

    let div = document.createElement("div");
    div.classList.add("ms-2");
    div.classList.add("me-auto");
    div.classList.add("text-start");
    div.classList.add("align-items-start");
    div.classList.add("w-100");

    let titleDiv = document.createElement("div");
    titleDiv.classList.add("fw-bold");
    titleDiv.append(title);

    div.append(titleDiv);
    div.append(answerField);

    li.append(div);

    return li;
}

function answerFieldShort(data){
    let div = document.createElement("div");
    div.classList.add("py-2");

    let label = document.createElement("label");
    label.setAttribute( "for","shortAns-" + data.id);               // <------ ID otazky aby sa mohlo pridat k policku tu
    label.append("odpoveď:");

    let input = document.createElement("input");
    input.classList.add("form-control");
    input.setAttribute("type", "text");
    input.setAttribute("aria-describedby", "odpoved");
    input.setAttribute("id", "shortAns-" + data.id);                // a aj tu

    div.append(label);
    div.append(input);

    return div;
}

function answerFieldMore(data){
    let div = document.createElement("div");
    div.classList.add("py-2");

    jQuery.each(data.option, function() {                           //<-------kazdu moznost
        div.append(addOption(data.option));
    });

    return div;
}

function addOption(data){
    let div = document.createElement("div");
    div.classList.add("form-check");

    let input = document.createElement("input");
    input.classList.add("form-check-input");
    input.setAttribute("type", "checkbox");
    input.setAttribute("value", "");
    input.setAttribute("aria-describedby", "odpoved");
    input.setAttribute("id", "moreAnsCheck-" + data.id);                // <------ sem ID odpovede , more_ans->id

    let label = document.createElement("label");
    label.classList.add("form-check-label");
    label.setAttribute( "for","moreAnsCheck-" + data.id);               // a aj tu

    label.append(data.title);                                           //<------- sem Title moznosti

    div.append(input);
    div.append(label);

    return div;
}

function answerFieldMath(data.question){
    let mathField = document.createElement("math-field");
    mathField.classList.add("math-style");
    mathField.setAttribute("virtual-keyboard-mode", "onfocus");
    mathField.setAttribute("id", "mathCheck-" + data.id);

    return mathField;
}