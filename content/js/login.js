$(document).ready(function() {
  var message = $('#message');
  if ($(message).length) {
    setTimeout(function() {
      $(message).fadeOut("slow");
    }, 1500);
  }
});

$('#login_form').submit(function() {
    var username_length = $("#username").val().length;
    var pwd_length = $("#password").val().length;
    if(username_length==0){
      var alert = $("<div></div>");
      alert.addClass("alert");
      alert.addClass("alert-danger");
      alert.addClass("text-center");
      alert.html("Please enter your username.");
      $(".post_error").html(alert);
      $("#username").focus();
      return false;
    }
    else if(pwd_length==0){
      var alert = $("<div></div>");
      alert.addClass("alert");
      alert.addClass("alert-danger");
      alert.addClass("text-center");
      alert.html("Please enter your password.");
      $(".post_error").html(alert);
      $("#password").focus();
      return false;
    }
    else{
      return true;
    }
});
