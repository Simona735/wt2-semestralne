$(document).ready(function () {
    $('#teacherButton').click(toggleSignUp);
    $('#studentButton').click(toggleSignUp);
})

function toggleSignUp(e){
    e.preventDefault();
    $('#teacherSignInForm').toggle(); // display:block or none
    $('#studentSignInForm').toggle(); // display:block or none

    if($('#studentButton').hasClass( "active" )){
        $('#studentButton').removeClass( "active" );
        $('#teacherButton').addClass("active");
    }else{
        $('#studentButton').addClass("active");
        $('#teacherButton').removeClass( "active" );
    }
}

function switchActive(id){
    var active = 0;

    if($("#switch-"+ id).prop("checked")){
        active = 1;
    }

    $.post( "../ModelControllers/TestModelController.php", { activeState: active, testId: id});
}

function exportToCsv(element){
    console.log($(element));
    $.post( "../teacher/exportCSV.php", {type: "exportCSV", id: $(element).attr('id')})
        .done(function( data ) {
            const a = document.createElement("a");
            document.body.appendChild(a);
            //a.style = "display: none";
            const blob = new Blob([data], {type: "octet/stream"}),
                url = window.URL.createObjectURL(blob);
            a.href = url;
            a.download = "export-test.csv";
            a.click();
            window.URL.revokeObjectURL(url);
        });
}

function addToast(id, name){
    let divToast = document.createElement("div");
    let divFlex = document.createElement("div");
    let divBody = document.createElement("div");
    let button = document.createElement("button");


    divToast.classList.add("toast");
    divToast.classList.add("hide");
    divToast.classList.add("align-items-center");

    divToast.setAttribute("role", "alert");
    divToast.setAttribute("aria-live", "assertive");
    divToast.setAttribute("aria-atomic", "true");
    divToast.setAttribute("id", id);

    divFlex.classList.add("d-flex");

    divBody.classList.add("toast-body");

    button.classList.add("btn-close");
    button.classList.add("me-2");
    button.classList.add("m-auto");

    button.setAttribute("data-bs-dismiss", "toast");
    button.setAttribute("aria-label", "Close");

    divBody.append(name + ' opustil/a tab');

    divFlex.append(divBody);
    divFlex.append(button);

    divToast.append(divFlex);

    return divToast;
}


