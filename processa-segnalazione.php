<?php
require_once 'bootstrap.php';

// Controllo sicurezza: Verifica che l'utente sia loggato e sia Super Admin
// (Scommenta queste righe quando avrai implementato il login completo)
/*
if(!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] != 'super_admin'){
    // Se non è admin, lo spediamo via
    header("Location: login.php");
    exit;
}
*/

// Verifichiamo che ci sia almeno un'azione impostata
if(isset($_POST["azione"])){
    
    $azione = $_POST["azione"];

    // --- CASO 1: IGNORA E RISOLVI (Dalle Segnalazioni) ---
    // L'admin ha deciso che la segnalazione non richiede azioni drastiche.
    if($azione == "annulla_segnalazione" && isset($_POST["id_segnalazione"])){
        $id_segnalazione = $_POST["id_segnalazione"];
        $dbh->resolveReport($id_segnalazione);
        
        // Torna alle segnalazioni
        header("Location: segnalazioni.php");
        exit;
    }

    // --- CASO 2: ELIMINA ANNUNCIO (Dalle Segnalazioni) ---
    // L'annuncio viola le regole. Lo cancelliamo e chiudiamo la segnalazione.
    elseif($azione == "elimina_annuncio" && isset($_POST["id_segnalazione"]) && isset($_POST["id_annuncio"])){
        $id_segnalazione = $_POST["id_segnalazione"];
        $id_annuncio = $_POST["id_annuncio"];
        
        // 1. Elimina fisicamente l'annuncio dal DB
        $dbh->deleteAnnuncio($id_annuncio);
        
        // 2. Segna la segnalazione come risolta
        $dbh->resolveReport($id_segnalazione);
        
        header("Location: segnalazioni.php");
        exit;
    }

    // --- CASO 3: BANNA UTENTE + RISOLVI (Dalle Segnalazioni) ---
    // L'utente è tossico. Lo eliminiamo (e a cascata sparisce tutto).
    elseif($azione == "ban_utente" && isset($_POST["id_segnalazione"]) && isset($_POST["id_utente"])){
        $id_segnalazione = $_POST["id_segnalazione"];
        $id_utente = $_POST["id_utente"];
        
        // 1. Elimina l'utente
        $dbh->deleteUser($id_utente);
        
        // 2. Segna la segnalazione come risolta
        $dbh->resolveReport($id_segnalazione);
        
        header("Location: segnalazioni.php");
        exit;
    }

    // --- CASO 4: BAN UTENTE DIRETTO (Dalla Lista Utenti "superadmin.php") ---
    // Azione eseguita direttamente dalla tabella utenti, senza segnalazione collegata.
    elseif($azione == "ban_utente_diretto" && isset($_POST["id_utente"])){
        $id_utente = $_POST["id_utente"];
        
        // Elimina l'utente
        $dbh->deleteUser($id_utente);
        
        // Torna alla lista utenti (superadmin.php o utenti.php a seconda di come l'hai chiamata)
        header("Location: superadmin.php"); 
        exit;
    }

} 

// Se qualcosa va storto o l'azione non è riconosciuta, torna alla home o pagina precedente
header("Location: index.php");
exit;
?>