<?php
require_once 'bootstrap.php';

if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $azione = $_POST["azione"]; // Recuperiamo l'azione (inserisci o modifica)
    
    // Dati comuni a entrambi i form
    $titolo = htmlspecialchars($_POST["titolo"]);
    $descrizione = htmlspecialchars($_POST["descrizione"]);
    $prezzo = $_POST["prezzo"];
    $luogo = htmlspecialchars($_POST["luogo"]);
    $id_utente = $_SESSION["id_utente"];

    if($azione == "modifica") {
        // CASO MODIFICA: Usiamo l'ID dell'annuncio esistente
        $id_annuncio = $_POST["id_annuncio"];
        $successo = $dbh->updateAnnuncio($id_annuncio, $titolo, $descrizione, $prezzo, $luogo, $id_utente);
        
        if($successo){
            header("location: dashboard.php?msg=modifica_ok");
        } else {
            header("location: dashboard.php?msg=errore_modifica");
        }
    } else {
        // CASO INSERIMENTO: Creiamo un nuovo record (comportamento standard)
        $successo = $dbh->insertAnnuncio($titolo, $descrizione, $prezzo, $luogo, $id_utente);
        
        if($successo){
            header("location: dashboard.php?msg=annuncio_creato");
        } else {
            header("location: dashboard.php?msg=errore_creazione");
        }
    }
}
?>