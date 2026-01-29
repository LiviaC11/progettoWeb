<?php
require_once 'bootstrap.php';

// Se l'utente è già loggato, reindirizza alla dashboard
if(isset($_SESSION["id_utente"])){
    header("location: dashboard.php");
    exit();
}

// 1. Controlliamo prima se il form è stato inviato
if(isset($_POST["email"]) && isset($_POST["password"])){
    
    // 2. Recuperiamo e sanifichiamo i dati SUBITO
    $email = ($_POST["email"]);
    $nome = ($_POST["nome"]);
    $cognome = ($_POST["cognome"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $scelta_casa = $_POST["scelta_casa"];

    // 3. ORA facciamo il controllo sull'email esistente
    if($dbh->checkEmailExists($email)) {
$templateParams["errore_registrazione"] = "Email già registrata. <a href='login.php'>Vai al login</a>";    } else {
        // 4. Procediamo con la registrazione solo se l'email è libera
        $id_utente = false;

        if($scelta_casa == "crea") {
            $nome_casa = ($_POST["nome_casa"]);
            $id_utente = $dbh->registerWithNewHouse($nome, $cognome, $email, $password, $nome_casa);
        } elseif ($scelta_casa == "unisciti") {
            $codice_invito = ($_POST["codice_invito"]);
            $id_utente = $dbh->registerToExistingHouse($nome, $cognome, $email, $password, $codice_invito);
            
            if(!$id_utente){
                $templateParams["errore_registrazione"] = "Codice invito non valido!";
            }
        } else {
            $id_utente = $dbh->registerUser($nome, $cognome, $email, $password);
        }

        // Se la registrazione ha avuto successo, avviamo la sessione
        if($id_utente){
            $_SESSION["id_utente"] = $id_utente;
            $_SESSION["nome"] = $nome;
            $_SESSION["ruolo"] = ($scelta_casa == "crea") ? "admin_casa" : "studente";

            $utente_appena_creato = $dbh->getUserById($id_utente);
            $_SESSION["id_casa"] = $utente_appena_creato["id_casa"];
            
            header("location: dashboard.php?msg=Benvenuto su CoHappy!");
            exit();
        } elseif(!isset($templateParams["errore_registrazione"])) {
            $templateParams["errore_registrazione"] = "Errore durante la registrazione. Riprova.";
        }
    }
}

$templateParams["titolo"] = "CoHappy - Registrazione";
$templateParams["nome"] = "template/registrazione_template.php";

require 'template/base.php';
?>