<?php
require_once 'bootstrap.php';

// Controllo se l'utente è loggato
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $prezzo = $_POST["prezzo"];
    $luogo = $_POST["luogo"];
    $id_utente = $_SESSION["id_utente"];

    // Chiamata alla funzione del DatabaseHelper
    $successo = $dbh->insertAnnuncio($titolo, $descrizione, $prezzo, $luogo, $id_utente);

    if($successo){
        // Ricarica la dashboard con un messaggio di successo
        header("location: dashboard.php?msg=annuncio_creato");
    } else {
        header("location: dashboard.php?msg=errore_creazione");
    }
}
?>