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
    var exportButton = document.getElementById("export-"+ id);//.disabled = true;

    console.log("evaluateButton" + evaluateButton.disabled);
    console.log("exportButton" + exportButton.disabled);

    if($("#switch-"+ id).prop("checked")){
        active = 1;
        evaluateButton.disabled = true;
        exportButton.disabled = true;
    }else{
        active = 0;
        evaluateButton.disabled = false;
        exportButton.disabled = false;
    }

    $.post( "../ModelControllers/TestModelController.php", { activeState: active, testId: id});
}
