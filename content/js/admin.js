var error = false;
var password_length = null;

$('#admin_information_form').submit(function(){
    password_length = $('#password').val().trim().length;
    error = false;
    var username_length = $('#username').val().trim().length;
    var password = $('#password').val();
    var pwd_again = $('#pwd_again').val();

    if(username_length==0){
        error = true;
        $('#empty_username').show();
    }
    if (password_length==0) {
        error = true;
        $('#empty_password').show();
    }
    if (password!=pwd_again) {
        error = true;
        $('#password_again_message').html("Both password do not match, please type again your password.");
        $('#password_again_message').show();
    }
    if (password==pwd_again) {
        if (password_length <= 6) {
            error = true;
            $('#empty_password').html("Passwords must be at least 7 characters");
            $('#empty_password').show();
            $('#password_again_message').hide();
        } else {
            error = false;
        }
    }
    else{
        $('#empty_username').hide();
        $('#empty_password').hide();
    }

    return !error;
});

// $('#password').on('focusout', function() {
//     password_length = $('#password').val().trim().length;
//     if(password_length <= 6) {
//         error = true;
//         $('#empty_password').html("Passwords must be at least 7 characters");
//         $('#empty_password').show();
//     } else {
//         $('#empty_password').hide();
//     }
// });