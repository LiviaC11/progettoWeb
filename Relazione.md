# Relazione Tecnica: Progetto CoHappy 🏠
**Sviluppo di una piattaforma web per la gestione collaborativa di unità abitative universitarie**

## Sommario
Il presente documento espone le fasi di analisi, progettazione e implementazione di **CoHappy**, un'applicazione web orientata all'ottimizzazione della convivenza tra studenti universitari fuori sede. Il sistema integra moduli per la gestione della trasparenza finanziaria, l'organizzazione dei turni domestici e un marketplace per l'allocazione di posti letto.

---

## 1. Analisi del Problema e Obiettivi
La condivisione di un alloggio in ambito universitario presenta criticità ricorrenti legate alla comunicazione interpersonale e alla gestione logistica. Gli obiettivi prefissati per CoHappy sono:

* **Digitalizzazione della gestione domestica:** Trasformare processi analogici (divisione spese, turni pulizie) in flussi di dati tracciabili.
* **Trasparenza Amministrativa:** Fornire uno strumento super partes per il monitoraggio dei bilanci comuni.
* **Moderazione e Sicurezza:** Implementare un sistema di controllo centralizzato per garantire la qualità degli annunci e la tutela della community.

## 2. Architettura del Software
L'applicazione adotta un'architettura basata sul pattern **Model-View-Controller (MVC)** semplificato, mirata alla separazione delle responsabilità e alla manutenibilità del codice.

### 2.1 Stack Tecnologico
* **Backend:** Linguaggio PHP 8.x. Gestisce la logica di business, l'autenticazione tramite sessioni e l'elaborazione dei dati.
* **Database:** RDBMS MySQL. Assicura la persistenza dei dati e l'integrità referenziale attraverso vincoli di *foreign key*.
* **Frontend:** HTML5 semantico e CSS3, integrati con il framework **Bootstrap 5** per garantire un'interfaccia responsive.
* **Client-side Logic:** JavaScript (Vanilla) impiegato per la validazione dinamica dei form e l'interattività dei componenti dell'interfaccia.

### 2.2 Strato di Persistenza: DatabaseHelper
L'interazione con la base di dati è centralizzata nella classe `DatabaseHelper`. Questo componente astrae le query SQL utilizzando sistematicamente **Prepared Statements**. Tale approccio garantisce la protezione contro vulnerabilità di tipo *SQL Injection* e standardizza le operazioni CRUD (Create, Read, Update, Delete) per l'intera applicazione.

## 3. Modellazione della Base di Dati
Il database `cohappy_db` è stato progettato seguendo i principi di normalizzazione. Le entità principali e le relative relazioni includono:

* **Utenti:** Memorizza anagrafiche e credenziali (protette con algoritmo di hashing BCRYPT). Include una gestione a tre livelli di privilegio: `studente`, `admin_casa` e `super_admin`.
* **Case:** Entità centrale a cui gli utenti si legano tramite un `codice_invito` univoco generato algoritmicamente.
* **Annunci:** Gestisce le inserzioni immobiliari, correlate a file multimediali salvati fisicamente sul server nella directory `img/`.
* **Spese e Turni Pulizie:** Entità transazionali per il tracciamento dei flussi economici e la pianificazione delle attività manutentive.
* **Candidature:** Gestisce il flusso di interazione tra potenziali inquilini e amministratori d'alloggio.

## 4. Design e User Experience (UX)
### 4.1 Approccio Mobile-First
In fase di progettazione, è stata data priorità alla fruizione tramite dispositivi mobili. L'interfaccia è costruita su una griglia fluida che permette una visualizzazione ottimale su smartphone, facilitando l'inserimento rapido di spese o la verifica dei turni durante la quotidianità domestica.

### 4.2 Gamification e Engagement
Per incentivare la cooperazione proattiva, è stato implementato un sistema di **Gamification**. Al completamento dei turni di pulizia, il sistema aggiorna dinamicamente il punteggio dell'utente, alimentando una classifica interna alla casa che promuove la partecipazione attraverso una competizione amichevole.

## 5. Funzionalità Core e Logica Applicativa
### 5.1 Gestione delle Risorse Multimediali
L'applicazione integra un modulo per l'upload di immagini gestito tramite la funzione `handleImageUpload`. Il sistema rinomina i file in modo univoco per prevenire collisioni nel file system e memorizza nel database esclusivamente il percorso relativo, ottimizzando l'efficienza dello storage e le prestazioni di caricamento.

### 5.2 Sicurezza e Moderazione
Il sistema di **Segnalazioni** consente agli utenti di segnalare contenuti o profili inappropriati. I `super_admin` dispongono di una dashboard dedicata per la risoluzione delle dispute, con poteri di cancellazione contenuti e interdizione utente (*ban*), con conseguente eliminazione a cascata dei record correlati per preservare la coerenza dei dati.

## 6. Conclusioni
CoHappy si configura come una soluzione scalabile e robusta, capace di rispondere concretamente alle esigenze del target universitario. L'integrazione di tecnologie web standard e l'attenzione alla sicurezza rendono il sistema una base solida per futuri sviluppi incrementali.
