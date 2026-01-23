document.addEventListener("DOMContentLoaded", function() {
    const acceptBtn = document.getElementById("accept-cookies");
    const banner = document.getElementById("cookie-banner");

    if (acceptBtn) {
        acceptBtn.addEventListener("click", function() {
            // 1. Imposta il cookie (durata 1 anno)
            // Il nome 'cohappy_cookie_consent' deve corrispondere a quello controllato in utils/functions.php
            const date = new Date();
            date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000)); // 365 giorni
            const expires = "expires=" + date.toUTCString();
            
            // SameSite=Lax è importante per la sicurezza moderna
            document.cookie = "cohappy_cookie_consent=true;" + expires + ";path=/;SameSite=Lax";

            // 2. Nascondi il banner visivamente (per non dover ricaricare la pagina)
            if (banner) {
                banner.style.transition = "opacity 0.5s";
                banner.style.opacity = "0";
                setTimeout(() => banner.remove(), 500); // Rimuove l'elemento dal DOM dopo l'animazione
            }
        });
    }
});