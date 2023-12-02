document.addEventListener("DOMContentLoaded", function() {
    var emailField = document.getElementById("user_email");
    var confirmEmailField = document.getElementById("confirm_user_email");

    function validateEmails() {
        var email = emailField.value;
        var confirmEmail = confirmEmailField.value;

        if (email !== confirmEmail) {
            confirmEmailField.setCustomValidity("Email addresses must match");
        } else {
            confirmEmailField.setCustomValidity("");
        }
    }

    emailField.addEventListener("input", validateEmails);
    confirmEmailField.addEventListener("input", validateEmails);
});