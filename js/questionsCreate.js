$(document).ready(function () {
    $('#short-question').click(function () {
        $.post( "../../app/src/addTest.php", function( data ) {
            console.log(data);
        });
    });

    $('#multiple-question').click(function () {
        console.log("multiple-question");
    });

    $('#pair-question').click(function () {
        console.log("pair-question");
    });

    $('#draw-question').click(function () {
        console.log("draw-question");
    });

    $('#math-question').click(function () {
        console.log("math-question");
    });
});


function createShortAnsQuestion(){
    var formBody = $( "#testContent");
    formBody.append("otazka");
}

function createQuestionWrapper(){
    let li = document.createElement("li");
    li.classList.add("list-group-item");
    li.classList.add("d-flex");
    li.classList.add("justify-content-between");

    let div1 = document.createElement("div");
    div1.classList.add("ms-2");
    div1.classList.add("me-auto");
    div1.classList.add("text-start");
    div1.classList.add("g");
    div1.classList.add("w-100");

    div1.append(addShortAnsTitle());
    div1.append(addShortAnsAnswer());

    let div2 = document.createElement("div");

    div2.append(addCloseButton());

    li.append(div1);
    li.append(div2);

    return li;
}

function addCloseButton(){
    let a = document.createElement("a");
    a.setAttribute("href", "#");
    a.classList.add("btn-exit");

    let i = document.createElement("i");
    i.classList.add("bi");
    i.classList.add("bi-x-circle-fill");

    a.append(i);

    return a;
}



function addShortAnsTitle(){
    let div = document.createElement("div");
    div.classList.add("fw-bold");

    let label = document.createElement("label");
    label.setAttribute( "for","questionTitle");
    label.append("otázka:");

    let textarea = document.createElement("textarea");
    textarea.classList.add("form-control");
    textarea.setAttribute("placeholder", "otázka");
    textarea.setAttribute("id", "questionTitle");


    div.append(label);
    div.append(textarea);

    return div;
}


function addShortAnsAnswer(){
    let div = document.createElement("div");
    div.classList.add("py-2");

    let label = document.createElement("label");
    label.setAttribute( "for","answerValue");
    label.append("odpoveď:");

    let input = document.createElement("input");
    input.classList.add("form-control");

    input.setAttribute("type", "text");
    input.setAttribute("aria-describedby", "odpoved");
    input.setAttribute("id", "answerValue");

    div.append(label);
    div.append(input);

    return div;
}

// <li className="list-group-item d-flex justify-content-between">
//     <div className="ms-2 me-auto text-start align-items-start w-100">
//         <div className="fw-bold">
//             <label htmlFor="floatingTextarea">otázka:</label>
//             <textarea className="form-control" placeholder="Otázka" id="floatingTextarea"></textarea>
//
//         </div>
//         <div className="py-2">
//             <label htmlFor="example2">odpoveď:</label>
//             <input type="text" className="form-control" id="example2" aria-describedby="odpoved">
//         </div>
//     </div>
//     <div>
//         <a href="#" className="btn-exit">
//             <i className="bi bi-x-circle-fill"></i>
//         </a>
//     </div>
// </li>