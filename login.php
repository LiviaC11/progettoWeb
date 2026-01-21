<?php
require_once 'bootstrap.php';

//verifica che l'aggiornamento pw sia andato bene
if(isset($_GET["msg"]) && $_GET["msg"] == "password_aggiornata"){
    $templateParams["messaggio_successo"] = "Password aggiornata con successo! Ora puoi accedere.";
}

// Se l'utente è già loggato, lo mandiamo direttamente alla dashboard
if(isset($_SESSION["id_utente"])){
    header("location: dashboard.php");
    exit();
}

// Logica di controllo login
if(isset($_POST["email"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
    if($login_result){
        // Salviamo i dati dell'utente nella sessione
        $_SESSION["id_utente"] = $login_result["id_utente"];
        $_SESSION["nome"] = $login_result["nome"];
        $_SESSION["ruolo"] = $login_result["ruolo"];
        $_SESSION["id_casa"] = $login_result["id_casa"];
        
        header("location: dashboard.php");
        exit();
    } else {
        $templateParams["errore_login"] = "Email o password errati!";
    }
}

$templateParams["titolo"] = "CoHappy - Login";
$templateParams["nome"] = "login_template.php"; // Ricordati di creare questo file in template/

require 'template/base.php';
?>