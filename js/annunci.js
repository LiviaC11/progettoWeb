document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Prendo i riferimenti agli elementi input
    const inputTesto = document.getElementById('filtro-testo');
    const inputDove = document.getElementById('filtro-dove');
    const selectPrezzo = document.getElementById('filtro-prezzo');
    
    // 2. Prendo tutte le card degli annunci e il messaggio di errore
    const annunciCards = document.querySelectorAll('.annuncio-item');
    const msgNessunRisultato = document.getElementById('nessun-risultato');

    // 3. Funzione principale di filtro
    function filtraAnnunci() {
        // Leggo i valori attuali degli input (convertiti in minuscolo per confronto facile)
        const testoCercato = inputTesto.value.toLowerCase();
        const luogoCercato = inputDove.value.toLowerCase();
        const prezzoRange = selectPrezzo.value;

        let annunciVisibili = 0;

        annunciCards.forEach(card => {
            // Leggo i dati nascosti (attributi data-*) della singola card
            const cardTitolo = card.getAttribute('data-titolo'); // Contiene titolo + descrizione
            const cardLuogo = card.getAttribute('data-luogo');
            const cardPrezzo = parseFloat(card.getAttribute('data-prezzo'));

            // A. Controllo Testo (titolo o descrizione contengono la parola?)
            const matchTesto = cardTitolo.includes(testoCercato);

            // B. Controllo Luogo (la città contiene la parola?)
            const matchLuogo = cardLuogo.includes(luogoCercato);

            // C. Controllo Prezzo
            let matchPrezzo = true;
            if (prezzoRange === '1') {
                matchPrezzo = cardPrezzo < 300;
            } else if (prezzoRange === '2') {
                matchPrezzo = cardPrezzo >= 300 && cardPrezzo <= 500;
            } else if (prezzoRange === '3') {
                matchPrezzo = cardPrezzo > 500;
            }
            // Se prezzoRange è 'all', matchPrezzo rimane true

            // DECISIONE FINALE: Mostrare o Nascondere?
            if (matchTesto && matchLuogo && matchPrezzo) {
                card.classList.remove('d-none'); // Rimuove la classe Bootstrap che nasconde
                annunciVisibili++;
            } else {
                card.classList.add('d-none'); // Aggiunge display: none
            }
        });

        // Gestione messaggio "Nessun Risultato"
        if (annunciVisibili === 0) {
            msgNessunRisultato.classList.remove('d-none');
        } else {
            msgNessunRisultato.classList.add('d-none');
        }
    }

    // 4. Attivo gli ascoltatori (Event Listeners)
    // Ogni volta che l'utente scrive o cambia selezione, esegui filtraAnnunci()
    if(inputTesto) inputTesto.addEventListener('input', filtraAnnunci);
    if(inputDove) inputDove.addEventListener('input', filtraAnnunci);
    if(selectPrezzo) selectPrezzo.addEventListener('change', filtraAnnunci);
});