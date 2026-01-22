<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "CoHappy - Recupero Password";
$msg = "";

// CASO 1: L'utente arriva dal link dell'email (presente $_GET['token'])
if (isset($_GET["token"])) {
    $token = $_GET["token"];
    
    // Verifichiamo se il token esiste ed è valido nel DB
    $utente = $dbh->getUserByToken($token);

    if ($utente) {
        // Token valido: mostriamo il form per cambiare la password
        $templateParams["id_utente"] = $utente["id_utente"];
        $templateParams["token"] = $token;
        $templateParams["nome"] = "template/form_nuova_password.php";
    } else {
        // Token scaduto o inesistente
        $msg = "Il link di recupero è scaduto o non è valido.";
        $templateParams["nome"] = "template/messaggio_errore.php";
    }
} 

// CASO 2: L'utente ha compilato il form della nuova password (POST)
elseif (isset($_POST["new_password"]) && isset($_POST["id_utente"])) {
    $id_utente = $_POST["id_utente"];
    $new_pwd = $_POST["new_password"];
    $confirm_pwd = $_POST["confirm_password"];

    if ($new_pwd === $confirm_pwd) {
        // Chiamiamo la funzione del DatabaseHelper creata prima
        $successo = $dbh->updatePwAndRemoveToken($id_utente, $new_pwd);
        
        if ($successo) {
            header("location: login.php?msg=password_aggiornata");
            exit();
        } else {
            $msg = "Errore durante l'aggiornamento. Riprova.";
        }
    } else {
        $msg = "Le password non coincidono.";
    }
}

require 'template/base.php';
?>