$(document).ready(function () {
    $('#short-question').click(function () {
        $.post( "../ModelControllers/BuildTestModelController.php", { addQuestion: true, T_ID: test_ID, Q_Title:"", Q_Type: "short_ans" })
            .done(function( data ) {
                console.log(data);
                data = $.parseJSON(data);
                createShortAnsQuestion(data.question_id, data.short_ans_id);                  //  <--   tam ID otazky   (namiesto 65)
                console.log("short-question");
            });
    });

    $('#multiple-question').click(function () {
        $.post( "../ModelControllers/BuildTestModelController.php", { addQuestion: true, T_ID: test_ID, Q_Title:"", Q_Type: "more_ans" })
            .done(function( data ) {
                console.log(data);
                data = $.parseJSON(data);
                createMoreAnsQuestion(data.question_id, data.more_ans_id_1, data.more_ans_id_2);                  //  <--   tam ID otazky   (namiesto 65)
                console.log("multiple-question");
            });
    });

    $('#pair-question').click(function () {
        $.post( "../ModelControllers/BuildTestModelController.php", { addQuestion: true, T_ID: test_ID, Q_Title:"", Q_Type: "pair_ans" })
            .done(function( data ) {
                console.log(data);
                data = $.parseJSON(data);
                createPairAnsQuestion(data.question_id, data.pair_ans_id_1, data.pair_ans_id_2);
                console.log("pair-question");//  <--   tam ID otazky   (namiesto 65)
            });
    });

    $('#draw-question').click(function () {
        $.post( "../ModelControllers/BuildTestModelController.php", { addQuestion: true, T_ID: test_ID, Q_Title:"", Q_Type: "pics_ans" })
            .done(function( data ) {
                console.log(data);
                data = $.parseJSON(data);
                createPicsAnsQuestion(data.question_id);
                console.log("draw-question");
            });
    });

    $('#math-question').click(function () {
        $.post( "../ModelControllers/BuildTestModelController.php", { addQuestion: true, T_ID: test_ID, Q_Title:"", Q_Type: "math_ans" })
            .done(function( data ) {
                console.log(data);
                data = $.parseJSON(data);
                createMathAnsQuestion(data.question_id);
                console.log("math-question");
            });
    });
});


function createShortAnsQuestion(id, short_ans_id){
    let formBody = $( "#testContent");
    let element1 = addQuestionTitle(id);
    let element2 = addShortAnsAnswer(short_ans_id);
    formBody.append(createQuestionWrapper(id, element1, element2));
}

function createQuestionWrapper(id, element1 , element2){
    let li = document.createElement("li");
    li.classList.add("list-group-item");
    li.classList.add("d-flex");
    li.classList.add("justify-content-between");
    li.classList.add("align-items-start");
    li.setAttribute("id", id);                              // <--- tu je ID otazky


    let div1 = document.createElement("div");
    div1.classList.add("ms-2");
    div1.classList.add("me-auto");
    div1.classList.add("text-start");
    div1.classList.add("align-items-start");
    div1.classList.add("w-100");

    div1.append(element1);
    div1.append(element2);

    let div2 = document.createElement("div");

    div2.append(addCloseButton(id));

    li.append(div1);
    li.append(div2);

    return li;
}

function addCloseButton(id){
    let a = document.createElement("a");
    a.setAttribute("onclick", "deleteQuestion("+id+")");                         // <- aj tu je ID otazky pre zrusenie otazky
    a.classList.add("btn-exit");

    let i = document.createElement("i");
    i.classList.add("bi");
    i.classList.add("bi-x-circle-fill");

    a.append(i);

    return a;
}



function addQuestionTitle(id){
    let div = document.createElement("div");
    div.classList.add("fw-bold");

    let label = document.createElement("label");
    label.setAttribute( "for","title-" + id);               //ID otazky pre title
    label.append("otázka:");

    let textarea = document.createElement("textarea");
    textarea.classList.add("form-control");
    textarea.setAttribute("placeholder", "otázka");
    textarea.setAttribute("id", "title-" + id);             // aj tu
    textarea.setAttribute("onchange", "changeInput(this, 'question_title')");             // aj tu

    div.append(label);
    div.append(textarea);

    return div;
}


function addShortAnsAnswer(id){         // <--- sem ID odpovede , short_ans->id
    let div = document.createElement("div");
    div.classList.add("py-2");

    let label = document.createElement("label");
    label.setAttribute( "for","shortAns-" + id);               //aby sa mohlo pridat k policku tu
    label.append("odpoveď:");

    let input = document.createElement("input");
    input.classList.add("form-control");

    input.setAttribute("type", "text");
    input.setAttribute("aria-describedby", "odpoved");
    input.setAttribute("id", "shortAns-" + id);                // a tu
    input.setAttribute("onchange", "changeInput(this, 'shortAns_correct')");

    div.append(label);
    div.append(input);

    return div;
}

function createMoreAnsQuestion(id, first_id, second_id){
    let formBody = $( "#testContent");
    let element1 = addQuestionTitle(id);
    let element2 = addMoreAnsOptions(id, first_id, second_id);
    formBody.append(createQuestionWrapper(id, element1, element2));
}

function addMoreAnsOptions(id, first_id, second_id){
    let ul = document.createElement("ul");
    ul.append(addEmptyOption(first_id));
    ul.append(addEmptyOption(second_id));
    ul.append(addNewOptionButton(id));

    return ul;
}

function addEmptyOption(id){                             // <--- sem ID odpovede , more_ans->id
    let li = document.createElement("li");
    li.classList.add("p-2");

    let div = document.createElement("div");
    div.classList.add("form-group");

    let label1 = document.createElement("label");
    label1.setAttribute( "for","moreAns-" + id);                  //aby sa mohlo pridat k policku tu
    label1.append("možnosť:");

    let input1 = document.createElement("input");
    input1.setAttribute("type", "text");
    input1.classList.add("form-control");
    input1.setAttribute("id", "moreAns-" + id);                   //a tu
    input1.setAttribute("aria-describedby", "otazka");
    input1.setAttribute("onchange", "changeInput(this, 'moreAns_title')");

    let input2 = document.createElement("input");
    input2.classList.add("form-check-input");
    input2.setAttribute("type", "checkbox");
    input2.setAttribute("value", "");
    input2.setAttribute("id", "moreAnsCheck-" + id);            // a sem kvoli chcek_ans
    input2.setAttribute("onchange", "changeInput(this, 'moreAns_correct')");

    let label2 = document.createElement("label");
    label2.classList.add("form-check-label");
    label2.setAttribute( "for","moreAnsCheck-" + id);           // a aj sem
    label2.append("správna");

    div.append(label1);
    div.append(input1);
    div.append(input2);
    div.append(label2);

    li.append(div);

    return li;

}

function addNewOptionButton(id){
    let li = document.createElement("li");
    li.classList.add("p-2");

    let button = document.createElement("button");
    button.setAttribute("type", "button");
    button.setAttribute("id", "moreans_button-"+id);                   //<--- tam je ID otazky
    button.setAttribute("onclick", "appendEmptyOption("+id+")");

    button.classList.add("btn");
    button.classList.add("btn-outline-primary");

    let i = document.createElement("i");
    i.classList.add("bi");
    i.classList.add("bi-plus-square-dotted");
    i.classList.add("me-1");

    button.append(i);
    button.append("pridať možnosť");

    li.append(button);

    return li;
}

function appendEmptyOption(id){
    console.log(id);
    $.post( "../ModelControllers/BuildTestModelController.php", { appendEmptyOption: true, Q_ID: id, Q_Type: "more_ans" })
        .done(function( data ) {
            console.log(data);
            $("#moreans_button-"+id).parent().remove();
            $("#"+id).find("ul").append(addEmptyOption(data)).append(addNewOptionButton(id));
        });
}

function createPairAnsQuestion(id, first_id, second_id){
    let formBody = $( "#testContent");
    let element1 = addQuestionTitle(id);
    let element2 = addEmptyPairs(id, first_id, second_id);
    formBody.append(createQuestionWrapper(id, element1, element2));
}

function addEmptyPairs(id, first_id, second_id){
    let div = document.createElement("div");
    div.classList.add("py-2");
    div.classList.add("context");
    div.append(addEmptyPair(first_id));
    div.append(addEmptyPair(second_id));
    div.append(addNewPairButton(id));

    return div;
}

function addEmptyPair(id){         // <--- sem ID odpovede , pair_ans->id
    let div = document.createElement("div");
    div.classList.add("py-2");
    div.classList.add("row");

    let divL = document.createElement("div");
    divL.classList.add("col");

    let divP = document.createElement("div");
    divP.classList.add("col");

    let label1 = document.createElement("label");
    label1.setAttribute( "for","left-" + id);              //tu bude
    label1.append("ľavý:");

    let input1 = document.createElement("input");
    input1.setAttribute("type", "text");
    input1.classList.add("form-control");
    input1.setAttribute("id", "left-" + id);               //tu
    input1.setAttribute("aria-describedby", "odpoved");
    input1.setAttribute("onchange", "changeInput(this, 'pairAns_title')");

    let label2 = document.createElement("label");
    label2.setAttribute( "for","right-" + id);             //tu
    label2.append("pravý:");

    let input2 = document.createElement("input");
    input2.setAttribute("type", "text");
    input2.classList.add("form-control");
    input2.setAttribute("id", "right-" + id);              //a tu
    input2.setAttribute("aria-describedby", "odpoved");
    input2.setAttribute("onchange", "changeInput(this, 'pairAns_title')");

    divL.append(label1);
    divL.append(input1);

    divP.append(label2);
    divP.append(input2);

    div.append(divL);
    div.append(divP);

    return div;
}

function addNewPairButton(id){
    let button = document.createElement("button");
    button.setAttribute("type", "button");
    button.setAttribute("id", "pairans_button-"+id);                      //<--- tam je ID otazky
    button.setAttribute("onclick", "appendEmptyPair("+id+")");
    button.classList.add("btn");
    button.classList.add("btn-outline-primary");
    button.classList.add("my-2");

    let i = document.createElement("i");
    i.classList.add("bi");
    i.classList.add("bi-plus-square-dotted");
    i.classList.add("me-1");

    button.append(i);
    button.append("pridať pár");

    return button;
}

function appendEmptyPair(id){
    console.log(id);
    $.post( "../ModelControllers/BuildTestModelController.php", { appendEmptyOption: true, Q_ID: id, Q_Type: "pair_ans" })
        .done(function( data ) {
            console.log(data);
            $("#pairans_button-"+id).remove();
            $("#"+id).find(".context").append(addEmptyPair(data)).append(addNewPairButton(id));
        });
}

function createPicsAnsQuestion(id){
    let formBody = $( "#testContent");
    let element1 = addQuestionTitle(id);
    formBody.append(createQuestionWrapper(id, element1, '(kresliaca otázka)'));
}

function createMathAnsQuestion(id){
    let formBody = $( "#testContent");
    let element1 = addQuestionTitle(id);
    formBody.append(createQuestionWrapper(id, element1, '(matematická otázka)'));
}

function changeInput(element, type){
    switch (type){
        case "question_title":
            console.log($(element));
            $.post( "../ModelControllers/BuildTestModelController.php", { update_QValue: "question_title", Q_ID: $(element).attr('id'), Q_Title:$(element).val()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "shortAns_correct":
            console.log($(element));
            $.post( "../ModelControllers/BuildTestModelController.php", { update_QValue: "shortAns_correct", SA_ID: $(element).attr('id'), SA_Correct:$(element).val()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "moreAns_title":
            console.log($(element));
            $.post( "../ModelControllers/BuildTestModelController.php", { update_QValue: "moreAns_title", MA_ID: $(element).attr('id'), MA_Title:$(element).val()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "moreAns_correct":
            console.log($(element).is(':checked'));
            $.post( "../ModelControllers/BuildTestModelController.php", { update_QValue: "moreAns_correct", MA_ID: $(element).attr('id'), MA_Correct:$(element).is(':checked')})
                .done(function( data ) {
                    console.log(data);
                });
            break;
        case "pairAns_title":
            console.log($(element));
            $.post( "../ModelControllers/BuildTestModelController.php", { update_QValue: "pairAns_title", PA_ID: $(element).attr('id'), PA_Title:$(element).val()})
                .done(function( data ) {
                    console.log(data);
                });
            break;
    }
}

function deleteQuestion(id){
    $.post( "../ModelControllers/BuildTestModelController.php", { question_ID: id})
        .done(function( data ) {
            console.log(data);
            $("#"+id).remove();
        });
}

function submitTest (id){
    $.post( "../ModelControllers/BuildTestModelController.php", { test_ID: id})
        .done(function( data ) {
            console.log(data);
            window.location = "index.php";
        });
}

