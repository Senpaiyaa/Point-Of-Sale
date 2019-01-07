var error = false;

$('#staff_information_form').submit(function(){
    var username_length = $('#username').val().trim().length;
    var fname_length = $('#fname').val().trim().length;
    var email_length = $('#email').val().trim().length;

    if(username_length===0){
        error = true;
        $('#empty_username').show();
    }
    if(fname_length === 0) {
        error = true;
        $('#empty_fname').show();
    }
    if(email_length === 0) {
        error = true;
        $('#empty_email').show();
    }

    else{
        $('#empty_username').hide();
        $('#empty_fname').hide();
        $('#empty_email').hide();
    }
    console.log(error);

    return !error;
});
