<?php
require_once 'bootstrap.php';

if(isset($_POST["email"])) {
    $email = $_POST["email"];
    
    // 1. Genera il token
    $token = bin2hex(random_bytes(32)); 
    
    // 2. Salva il token nel DB tramite DatabaseHelper
    $successo = $dbh->setRecoveryToken($email, $token);
    
    if($successo) {
        // In un sito reale sarebbe inviato tramite email
        //x testarlo senza bisogno di email facciamo comparire il link sullo schermo
        echo "Link di recupero generato: <a href='recupero.php?token=$token'>Recupera Password</a>";
    } else {
        echo "Email non trovata.";
    }
}
?>