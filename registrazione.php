<?php
require_once 'bootstrap.php';

// Se l'utente è già loggato, non ha senso che si registri
if(isset($_SESSION["id_utente"])){
    header("location: dashboard.php");
    exit();
}

if(isset($_POST["email"]) && isset($_POST["password"])){
    $nome = htmlspecialchars($_POST["nome"]);
    $cognome = htmlspecialchars($_POST["cognome"]);
    $email = htmlspecialchars($_POST["email"]);
    // Hashiamo la password per la sicurezza!
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $scelta_casa = $_POST["scelta_casa"]; // 'crea' o 'unisciti'

    if($scelta_casa == "crea") {
        $nome_casa = htmlspecialchars($_POST["nome_casa"]);
        // Funzione ipotetica che crea casa e utente (vedi DatabaseHelper sotto)
        $id_utente = $dbh->registerWithNewHouse($nome, $cognome, $email, $password, $nome_casa);
    } else {
        $codice_invito = htmlspecialchars($_POST["codice_invito"]);
        // Funzione ipotetica che unisce l'utente a una casa tramite codice
        $id_utente = $dbh->registerToExistingHouse($nome, $cognome, $email, $password, $codice_invito);
    }

   if($id_utente){
        $_SESSION["id_utente"] = $id_utente;
        $_SESSION["nome"] = $nome;
        $_SESSION["ruolo"] = ($scelta_casa == "crea") ? "admin_casa" : "studente";
        
        header("location: dashboard.php?msg=Benvenuto su CoHappy!");
        exit();
    }
}

$templateParams["titolo"] = "CoHappy - Registrazione";
$templateParams["nome"] = "template/registrazione_template.php";

require 'template/base.php';
?>