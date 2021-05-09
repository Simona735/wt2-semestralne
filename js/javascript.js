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
