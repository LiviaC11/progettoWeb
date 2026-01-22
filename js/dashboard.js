//gestione copia codice invito negli appunti
function copyToClipboard() {
    // Recupera il codice 
    const btn = document.querySelector('.btn-copy-code');
    const code = btn.getAttribute('data-code');

    if (!code) {
        console.error("Codice non trovato!");
        return;
    }

    navigator.clipboard.writeText(code).then(() => {
        // Feedback all'utente, positiva se copiato
        const originalText = btn.innerHTML;
        btn.innerHTML = "✅ Copiato!";
        btn.classList.replace('btn-link', 'btn-success');
        btn.classList.add('text-white');

        // Ripristina il bottone dopo 2 secondi
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.replace('btn-success', 'btn-link');
            btn.classList.remove('text-white');
        }, 2000);
    }).catch(err => {
        alert("Errore durante la copia: " + err);
    });
}

document.addEventListener('DOMContentLoaded', () => {
});