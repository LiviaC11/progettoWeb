# CoHappy - Sistema di Gestione Collaborativa per l'Housing Universitario 🏠

CoHappy è una piattaforma web modulare progettata per ottimizzare la convivenza tra studenti universitari fuori sede. Il sistema centralizza la gestione delle dinamiche domestiche, la contabilità interna e il marketplace per la ricerca di coinquilini in un unico ambiente digitale sicuro e scalabile.

## 🏛️ Architettura e Tecnologie
Il progetto è stato sviluppato seguendo standard di ingegneria del software orientati alla manutenibilità e alla sicurezza:

* **Backend:** PHP 8.x (Architettura basata su pattern MVC semplificato).
* **Database:** MySQL/MariaDB con integrità referenziale garantita da vincoli di Foreign Key.
* **Frontend:** Interfaccia responsive basata su HTML5, CSS3 e Framework Bootstrap 5.
* **Sicurezza:** Prevenzione SQL Injection tramite Prepared Statements e hashing delle credenziali con algoritmo BCRYPT.

## 🚀 Funzionalità Implementate

### 1. Gestione Autenticazione e Profili
* **Sistema di Accesso:** Login e Logout con gestione delle sessioni sicure.
* **Registrazione Dinamica:** Possibilità di creare un nuovo account, creare contestualmente una nuova "Casa" o unirsi a una esistente tramite codice invito univoco.
* **Recupero Credenziali:** Workflow completo per il ripristino della password tramite token.
* **Gamification:** Sistema di punteggio utente basato sul completamento dei task domestici.

### 2. Marketplace Annunci e Candidature
* **Pubblicazione:** Gli utenti con ruolo "Admin Casa" possono pubblicare inserzioni complete di descrizione, prezzo e immagini.
* **Image Handling:** Caricamento fisico delle immagini sul server con rinomina univoca per evitare conflitti nel file system.
* **Candidature Esterne:** Gli utenti non registrati possono inviare candidature corredate da messaggio e foto, gestite privatamente dai proprietari tramite popup dedicato.

### 3. Gestione Unità Abitativa (Dashboard Interna)
* **Modulo Spese (CRUD):** Inserimento e monitoraggio degli esborsi economici comuni con tracciamento degli autori.
* **Pianificazione Pulizie:** Calendario dei turni con gestione degli stati (Da fare/Completato) e verifica delle scadenze.
* **Codici Invito:** Generazione di codici alfanumerici per l'aggregazione di nuovi membri al nucleo abitativo.

### 4. Strumenti di Amministrazione e Moderazione (Super Admin)
* **Dashboard Statistica:** Visualizzazione dei KPI di sistema (utenti totali, annunci attivi, segnalazioni pendenti).
* **Gestione Utenti:** Tabella completa degli iscritti con funzionalità di Interdizione (Ban) e rimozione a cascata dei dati correlati.
* **Sistema di Reporting:** Gestione delle segnalazioni inviate dagli utenti per contenuti inappropriati o violazioni del regolamento.
