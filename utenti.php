<?php
require_once 'bootstrap.php';

// Controllo Admin (Scommenta quando hai il login)
/*
if(!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] != 'super_admin'){
    header("Location: login.php");
    exit;
}
*/

$templateParams["titolo"] = "CoHappy - Gestione Utenti";
$templateParams["nome"] = "template/visualizza_utenti.php"; // O il nome del tuo template

// QUESTA È LA RIGA CHE MANCAVA! 👇
// Devi riempire la scatola "utenti" con i dati dal database
$templateParams["utenti"] = $dbh->getAllUsers(); 

require 'template/base_admin.php';
?>