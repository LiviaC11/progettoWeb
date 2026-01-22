<?php
require_once 'bootstrap.php';

// 1. GESTIONE PASSWORD AGGIORNATA (Feedback)
if(isset($_GET["msg"]) && $_GET["msg"] == "password_aggiornata"){
    $templateParams["messaggio_successo"] = "Password aggiornata con successo! Ora puoi accedere.";
}

// 2. SE È GIÀ LOGGATO -> REDIRECT INTELLIGENTE
if(isset($_SESSION["id_utente"])){
    if($_SESSION["ruolo"] == 'super_admin'){
        header("Location: superadmin.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

// 3. LOGICA DI LOGIN
if(isset($_POST["email"]) && isset($_POST["password"])){
    
    // Controlliamo le credenziali nel DB
    $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
    
    if($login_result){
        // LOGIN RIUSCITO: Salviamo i dati in sessione
        $_SESSION["id_utente"] = $login_result["id_utente"];
        $_SESSION["nome"] = $login_result["nome"];
        $_SESSION["ruolo"] = $login_result["ruolo"];
        $_SESSION["id_casa"] = $login_result["id_casa"]; // Potrebbe essere NULL per super_admin

        
        if($login_result["ruolo"] == 'super_admin'){
            header("Location: superadmin.php"); // Admin va alla sua dashboard
        } else {
            header("Location: dashboard.php"); // Utenti normali vanno alla loro
        }
        exit();
        
    } else {
        // LOGIN FALLITO
        $templateParams["errore_login"] = "Email o password errati!";
    }
}

// 4. MOSTRA PAGINA DI LOGIN
$templateParams["titolo"] = "CoHappy - Login";
$templateParams["nome"] = "template/login_template.php"; 

require 'template/base.php';
?>