<?php
require_once 'bootstrap.php';

if(isset($_POST["email"])) {
    $email = $_POST["email"];
    $token = bin2hex(random_bytes(32));
    if($dbh->setRecoveryToken($email, $token)) {
        // Prepariamo i dati per il template invece di fare "echo"
        $templateParams["messaggio_successo"] = "Link di recupero generato (Simulazione Locale):";
        $templateParams["link_generato"] = "recupero.php?token=$token";
    } else {
        $templateParams["errore"] = "Email non trovata o errore nel sistema.";
    }
}
$templateParams["titolo"] = "CoHappy - Invio Recupero";
$templateParams["nome"] = "template/conferma_invio_recupero.php"; // Crea questo file o usa uno esistente
require 'template/base.php';
?>