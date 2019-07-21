$(document).ready(function() {
    $("#hideLogin").click(function() {
        $("#registerForm").fadeToggle("slow");
        $("#loginForm").toggle(1500);
        $("#loginForm").hide();
    });

    $("#hideRegister").click(function() {
        $("#loginForm").fadeToggle("slow");
        $("#registerForm").toggle(1500);
        $("#registerForm").hide();
    });
});