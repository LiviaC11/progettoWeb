<?php
require_once 'bootstrap.php';

// 1. PROTEZIONE BASE: Solo utenti loggati
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

$id_utente = $_SESSION["id_utente"];
$id_casa = $_SESSION["id_casa"] ?? null;

// 2. GESTIONE AZIONI (POST/GET)

// Unione ad una casa
if(isset($_POST["azione"]) && $_POST["azione"] == "unisciti_casa" && isset($_POST["codice_invito"])){
    $codice = htmlspecialchars($_POST["codice_invito"]);
    $nuovo_id_casa = $dbh->joinHouseWithCode($id_utente, $codice);
    
    if($nuovo_id_casa){
        $_SESSION["id_casa"] = $nuovo_id_casa;
        header("location: dashboard.php?successo=casa_unita");
        exit();
    } else {
        $templateParams["errore_casa"] = "Codice invito non valido.";
    }
}

// Abbandono casa
if(isset($_GET["azione"]) && $_GET["azione"] == "abbandona"){
    if($dbh->leaveHouse($id_utente)){
        $_SESSION["id_casa"] = null;
        header("location: dashboard.php");
        exit();
    }
}

// Nuovo Annuncio (Verifica RUOLO lato server)
if(isset($_POST["azione"]) && $_POST["azione"] == "inserisci_annuncio"){
    $user = $dbh->getUserById($id_utente);
    if($user["ruolo"] === "admin_casa") {
        $dbh->insertAnnuncio(
            htmlspecialchars($_POST["titolo"]),
            htmlspecialchars($_POST["descrizione"]),
            $_POST["prezzo"],
            htmlspecialchars($_POST["luogo"]),
            $id_utente
        );
        header("location: dashboard.php?msg=annuncio_pubblicato");
        exit();
    }
}

// 3. RECUPERO DATI PER IL TEMPLATE
// Nota: getUserById ora deve fare la JOIN con la tabella case come visto prima
$templateParams["utente"] = $dbh->getUserById($id_utente);

// Se l'utente non ha una casa, non carichiamo il resto dei dati
if ($id_casa) {
    $templateParams["miei_annunci"] = $dbh->getAnnunciByUtente($id_utente);
    $templateParams["spese_recenti"] = $dbh->getRecentExpenses($id_casa, 3);
    $templateParams["prossimo_turno"] = $dbh->getNextCleaningTurn($id_casa);
        $templateParams["turni_pulizie"] = $dbh->getTurniMeseSuccessivo($id_casa);

}

$templateParams["titolo"] = "CoHappy - Dashboard";
$templateParams["nome"] = "template/dashboard_template.php";

require 'template/base.php';
?>