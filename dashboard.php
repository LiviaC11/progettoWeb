<?php
require_once 'bootstrap.php';

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