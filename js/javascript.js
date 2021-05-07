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
