# [INSERISCI NOME PROGETTO QUI] - Gestione Collaborativa Unità Abitative

## 📖 Descrizione del Progetto
L’applicazione web fornisce un servizio di gestione collaborativa delle unità abitative studentesche, permettendo ai coinquilini di organizzare in modo semplice e condiviso le attività comuni.
Il sistema è progettato per facilitare la convivenza attraverso la gestione digitalizzata di spese, turni di pulizia e scadenze utenze, promuovendo al contempo l'incontro tra domanda e offerta per posti letto vacanti.

L’applicazione è progettata secondo principi di **accessibilità**, **mobile-first** e **user-centered**, al fine di garantire una fruizione efficace su diversi dispositivi.

## 🛠️ Architettura e Tecnologie
Il progetto rispetta i vincoli architetturali richiesti dalle specifiche:
* **Backend:** PHP (Native)
* **Frontend:** HTML5, CSS3 (Framework: Bootstrap), JavaScript (Vanilla)
* **Database:** MySQL/MariaDB

## 👥 Ruoli e Attori
Il sistema distingue tre tipologie principali di utenti:
1.  **Amministratore di Sistema (Super Admin):** Figura super partes che gestisce la piattaforma, modera i contenuti e gestisce le unità inattive.
2.  **Amministratore Interno (Studente):** Inquilino che crea e gestisce la propria unità abitativa.
3.  **Studente Fruitore (Inquilino):** Utente registrato che partecipa alle attività della casa.
4.  **Utente Non Registrato:** Visitatore che può consultare annunci.

## 🚀 Funzionalità

### Funzionalità Comuni
* Registrazione e Autenticazione (Login/Logout).
* Recupero password.
* Gestione profilo personale.

### Funzionalità Admin di Sistema
* Visualizzazione e cancellazione unità abitative inattive.
* Gestione utenti (ban/rimozione).
* Moderazione forum e annunci (rimozione contenuti inappropriati).
* Gestione delle segnalazioni.

### Funzionalità Studente (Inquilino/Admin Casa)
* **Gestione Unità:** Creazione unità, unione a un'unità esistente, visualizzazione dati, assegnazione ruolo admin interno.
* **Gestione Collaborativa (CRUD):**
    * Lista della spesa condivisa.
    * Gestione turni di pulizia.
    * Gestione utenze e scadenze pagamenti.
    * Attività extra.
* **Comunicazione:**
    * Forum interno all’unità abitativa (Bacheca messaggi).
    * Pubblicazione annunci "Cercasi Inquilino".

### Funzionalità Pubbliche (Utente Non Registrato)
* Visualizzazione annunci "Cercasi Inquilino".
* Invio candidature tramite form dedicato (Dati anagrafici, contatti, foto, messaggio).
* Visualizzazione informazioni pubbliche del servizio.

## 📝 Scenari d'Uso (Personas)

* **SCENARIO 1 (Luca - Utente Non Registrato):** Luca è uno studente fuori sede. Accede alla sezione pubblica "Cercasi Inquilino", individua un annuncio e contatta l'autore tramite il modulo dedicato senza doversi registrare.
* **SCENARIO 2 (Giulia - Studente Fruitore):** Giulia effettua il login e accede alla dashboard dell'appartamento. Consulta le scadenze, aggiorna la lista della spesa, controlla i turni di pulizia e propone attività extra (es. cene a tema).
* **SCENARIO 3 (Francesca - Admin Interno):** Francesca gestisce l'unità abitativa. Inserisce le nuove utenze, segna i pagamenti ricevuti dai coinquilini e pubblica annunci sul forum pubblico per cercare un nuovo inquilino per una stanza libera.

---

## 💡 Proposte di Sviluppo & Effetto WOW (To Do / In Discussione)

Idee aggiuntive per migliorare l'engagement e l'accessibilità (Target: 4/4 punti Design/WOW).

1.  **Gamification delle Pulizie 🏆**
    * Trasformare i turni in una classifica mensile. Assegnazione punti per task completati puntualmente.
    * *Obiettivo:* Incentivare la collaborazione tramite competizione amichevole.

2.  **Gestione Spese "Smart Split" 💸**
    * Calcolo automatico della quota pro-capite all'inserimento di una spesa (es. Bolletta 100€ -> 33€ a testa). Visualizzazione saldo debiti/crediti in dashboard.
    * *Obiettivo:* Utilità pratica avanzata per la gestione contabile.

3.  **Matching Avanzato Annunci ❤️**
    * Inclusione di "Tag Lifestyle" negli annunci (es. #Fumatore, #AnimaliAmmessi, #StudioIntenso) per filtrare la compatibilità.
    * *Obiettivo:* Migliorare la UX nella ricerca coinquilini.

4.  **Dark Mode Automatica 🌙**
    * Rilevamento delle preferenze di sistema dell'utente tramite JS per switch automatico del tema grafico.
    * *Obiettivo:* Design inclusivo e moderno.# progettoWeb