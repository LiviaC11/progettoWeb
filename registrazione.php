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
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    
    // Recuperiamo la scelta (crea, unisciti, nessuna)
    $scelta_casa = $_POST["scelta_casa"]; 

    $id_utente = false;

    // CASO 1: Crea Nuova Casa
    if($scelta_casa == "crea") {
        $nome_casa = htmlspecialchars($_POST["nome_casa"]);
        $id_utente = $dbh->registerWithNewHouse($nome, $cognome, $email, $password, $nome_casa);
    } 
    // CASO 2: Unisciti a Casa Esistente
    elseif ($scelta_casa == "unisciti") {
        $codice_invito = htmlspecialchars($_POST["codice_invito"]);
        $id_utente = $dbh->registerToExistingHouse($nome, $cognome, $email, $password, $codice_invito);
        
        // Se fallisce (codice errato), mostriamo errore
        if(!$id_utente){
            $templateParams["errore_registrazione"] = "Codice invito non valido!";
        }
    } 
    // CASO 3: Solo Registrazione (Nessuna casa)
    else {
        $id_utente = $dbh->registerUser($nome, $cognome, $email, $password);
    }

    // Se la registrazione è andata a buon fine
    if($id_utente){
        $_SESSION["id_utente"] = $id_utente;
        $_SESSION["nome"] = $nome;
        // Il ruolo dipende: se ha creato casa è admin, altrimenti studente
        $_SESSION["ruolo"] = ($scelta_casa == "crea") ? "admin_casa" : "studente";

        $utente_appena_creato = $dbh->getUserById($id_utente);
        $_SESSION["id_casa"] = $utente_appena_creato["id_casa"]; // Sarà NULL se ha scelto "nessuna"
        
        header("location: dashboard.php?msg=Benvenuto su CoHappy!");
        exit();
    } elseif(!isset($templateParams["errore_registrazione"])) {
        $templateParams["errore_registrazione"] = "Errore durante la registrazione. Riprova.";
    }
}

$templateParams["titolo"] = "CoHappy - Registrazione";
$templateParams["nome"] = "template/registrazione_template.php";

require 'template/base.php';
?>