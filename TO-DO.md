🚀 CoHappy Project - To-Do List & Roadmap
Status Attuale: Struttura MVC impostata (frontend statico in PHP). Obiettivo: Arrivare ai 32 punti (CRUD, Login, Database, WOW Effect).

🏗️ 1. Database (URGENTE 🚨)
Senza questo non possiamo fare nulla di dinamico. Mancano le tabelle su phpMyAdmin.

[ ] Creare Database: cohappy_db

[ ] Tabella utenti:

id_utente (INT, AI, PK)

nome (VARCHAR)

cognome (VARCHAR)

email (VARCHAR, UNIQUE)

password (VARCHAR - Hashata!)

ruolo (ENUM: 'studente', 'admin_casa', 'super_admin')

foto_profilo (VARCHAR)

id_casa (INT, FK -> case)

[ ] Tabella case (Unità Abitative):

id_casa (INT, AI, PK)

nome_casa (VARCHAR)

codice_invito (VARCHAR, UNIQUE)

[ ] Tabella annunci:

id_annuncio (INT, AI, PK)

titolo (VARCHAR)

descrizione (TEXT)

prezzo (DECIMAL)

foto (VARCHAR)

data_pubblicazione (DATETIME)

id_utente (INT, FK -> utenti)

[ ] Tabella spese (CRUD 1):

id_spesa (INT, AI, PK)

descrizione (VARCHAR)

importo (DECIMAL)

data_spesa (DATE)

chi_ha_pagato (INT, FK -> utenti)

id_casa (INT, FK -> case)

[ ] Tabella pulizie (CRUD 2 / WOW):

id_turno (INT, AI, PK)

compito (VARCHAR)

data_scadenza (DATE)

assegnato_a (INT, FK -> utenti)

stato (BOOLEAN: fatto/non fatto)

💻 2. Interfacce Mancanti (Frontend)
Attualmente hai solo Home, Annunci e Contatti. Servono le pagine funzionali.

[ ] Registrazione (registrazione.php):

Form per creare account.

Checkbox: "Crea una nuova casa" vs "Unisciti con codice".

[ ] Login Funzionante (login.php):

Il form c'è, ma non fa nulla. Deve controllare il DB e avviare la sessione.

[ ] Dashboard Utente (dashboard.php):

Pagina CHIAVE. È dove l'utente atterra dopo il login.

Deve mostrare: "Ciao [Nome]", riepilogo spese, prossimi turni pulizie.

[ ] Gestione Casa (casa.php):

Tabella spese (chi deve quanto a chi).

Tabella turni pulizie.

Bottone "Aggiungi Spesa" / "Assegna Turno".

[ ] Profilo (profilo.php):

Modifica foto, cambia password.

⚙️ 3. Logica PHP (Backend)
Qui si prendono i punti veri (8 punti CRUD + 4 punti Auth).

[ ] File db/database.php:

Scrivere la classe DatabaseHelper con le funzioni:

checkLogin($email, $password)

registraUtente(...)

getAnnunci()

insertSpesa(...)

getSpeseCasa($id_casa)

[ ] Script processa-login.php:

Riceve i dati dal form login, controlla DB, reindirizza a dashboard.php.

[ ] Script processa-registrazione.php:

Salva il nuovo utente nel DB.

✨ 4. Effetto WOW (Gamification)
Hai scelto la gamification nel README. Implementiamola.

[ ] Database: Aggiungi colonna punti (INT) alla tabella utenti.

[ ] Logica:

Quando un utente clicca "Ho fatto le pulizie" -> UPDATE utenti SET punti = punti + 10.

[ ] Frontend:

Nella Dashboard, mostra una classifica: "🏆 Queen delle pulizie: [Nome] - 500pt".

🗺️ Ordine di Battaglia Consigliato
Database: Crea subito le tabelle su phpMyAdmin.

Auth: Fai funzionare Registrazione e Login. Se non entri, non puoi testare il resto.

Dashboard: Crea la pagina vuota dove atterrare.

Annunci: Collega la pagina annunci.php al DB per leggere gli annunci veri invece di quelli finti.

Spese/Pulizie: Fai le CRUD.
