<?php
require_once 'bootstrap.php';

// Unione ad una casa tramite codice invito
if(isset($_POST["azione"]) && $_POST["azione"] == "unisciti_casa" && isset($_POST["codice_invito"])){
    $codice = htmlspecialchars($_POST["codice_invito"]);
    $nuovo_id_casa = $dbh->joinHouseWithCode($_SESSION["id_utente"], $codice);
    
    if($nuovo_id_casa){
        $_SESSION["id_casa"] = $nuovo_id_casa;
        header("location: dashboard.php?successo=casa_unita");
        exit();
    } else {
        $templateParams["errore_casa"] = "Codice invito non valido o scaduto.";
    }
}

// Protezione della pagina: solo utenti loggati
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

$id_utente = $_SESSION["id_utente"];
$id_casa = $_SESSION["id_casa"] ?? null;
if (!$id_casa) {
    // Se non c'è la casa, rimandalo al login
    header("location: login.php");
    exit();
}

//gestione abbandono casa
if(isset($_GET["azione"]) && $_GET["azione"] == "abbandona"){
    $id_utente = $_SESSION["id_utente"];
    if($dbh->leaveHouse($id_utente)){
        $_SESSION["id_casa"] = null; // Rimuove il riferimento dalla sessione
        header("location: dashboard.php"); // Ricarica la dashboard (che ora sarà vuota)
        exit();
    }
}

// Recupero dati per la Dashboard
$templateParams["utente"] = $dbh->getUserById($id_utente);
$templateParams["miei_annunci"] = $dbh->getAnnunciByUtente($id_utente);
//$templateParams["classifica"] = $dbh->getHouseRanking($id_casa); 
$templateParams["spese_recenti"] = $dbh->getRecentExpenses($id_casa, 3);
$templateParams["prossimo_turno"] = $dbh->getNextCleaningTurn($id_casa);

$templateParams["titolo"] = "CoHappy - Dashboard";
$templateParams["nome"] = "template/dashboard_template.php";

require 'template/base.php';
?>