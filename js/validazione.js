document.addEventListener("DOMContentLoaded", function() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    const form = document.querySelector("form");

    // Funzione per validare la coincidenza password
    function validaPassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Le password non corrispondono");
            confirmPassword.classList.add("is-invalid");
        } else {
            confirmPassword.setCustomValidity("");
            confirmPassword.classList.remove("is-invalid");
            confirmPassword.classList.add("is-valid");
        }
    }

    // Ascolta l'input in tempo reale
    if (password && confirmPassword) {
        password.addEventListener("change", validaPassword);
        confirmPassword.addEventListener("keyup", validaPassword);
    }

    // Validazione base email (opzionale, Bootstrap la gestisce già in parte)
    const email = document.getElementById("email");
    if (email) {
        email.addEventListener("input", function() {
            if (email.validity.typeMismatch) {
                email.setCustomValidity("Inserisci un indirizzo email valido");
            } else {
                email.setCustomValidity("");
            }
        });
    }
});