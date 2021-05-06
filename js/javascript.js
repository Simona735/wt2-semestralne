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
    // $(':input[type="submit"]').prop('disabled', true);7
    var evaluateButton = document.getElementById("evaluate-"+ id);//.disabled = true;
    var exportPDF = document.getElementById("exportPDF-"+ id);//.disabled = true;
    var exportCSV = document.getElementById("exportCSV-"+ id);//.disabled = true;

    if($("#switch-"+ id).prop("checked")){
        active = 1;
        evaluateButton.classList.add("disabled");
        exportPDF.classList.add("disabled");
        exportCSV.classList.add("disabled");
    }else{
        active = 0;
        evaluateButton.classList.remove("disabled");
        exportPDF.classList.remove("disabled");
        exportCSV.classList.remove("disabled");
    }

    $.post( "../ModelControllers/TestModelController.php", { activeState: active, testId: id});
}
