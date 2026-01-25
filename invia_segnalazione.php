<?php
require_once 'bootstrap.php';

// Solo gli utenti loggati dovrebbero poter segnalare
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

if(isset($_POST["id_annuncio"]) && isset($_POST["motivo"])){
    $id_annuncio = $_POST["id_annuncio"];
    $id_utente_segnalante = $_SESSION["id_utente"];
    $motivo = htmlspecialchars($_POST["motivo"]);
    $descrizione = htmlspecialchars($_POST["descrizione"]);
    $id_utente_segnalato = $_POST["id_utente_segnalato"]; // L'owner dell'annuncio

    // Chiamiamo la funzione del DB per salvare la segnalazione
    $successo = $dbh->creaSegnalazione($id_annuncio, $id_utente_segnalante, $id_utente_segnalato, $motivo, $descrizione);

    if($successo){
        header("location: annunci.php?msg=Segnalazione inviata. Grazie per il tuo aiuto! ✨");
    } else {
        header("location: annunci.php?err=Errore durante l'invio della segnalazione.");
    }
} else {
    header("location: annunci.php");
}
?>