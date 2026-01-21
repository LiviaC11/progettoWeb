<?php
require_once 'bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recupero e sanificazione dei dati
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $messaggio = htmlspecialchars($_POST['messaggio']);
    $id_annuncio= isset($_POST['id_annuncio']) ? intval($_POST['id_annuncio']) : 1;
    
    //Gestione dell'upload foto. Genero nome univoco per evitare sovrascritture e sposto il file 
    //nella cartella di destinazione
    $nomeFoto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        
        $nomeFoto = time() . "_" . basename($_FILES['foto']['name']);
        $targetFile = UPLOAD_DIR . $nomeFoto;
      
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
            $nomeFoto = null; // Reset se l'upload fallisce
        }
    }

    $risultato = $dbh->insertCandidatura($id_annuncio, $nome, $email, $messaggio, $nomeFoto);
    //  Placeholder per l'inserimento nel Database
    /* $dbh->insertCandidatura($nome, $email, $messaggio, $nomeFoto); */
    if($risultato){
        $templateParams["titolo"] = "CoHappy - Candidatura Inviata";
        $templateParams["nome"] = "risposta_template.php";
    } else {
    // Se qualcuno prova ad accedere a risposta.php senza inviare il form, lo rimandiamo agli annunci
    header("Location: annunci.php");
    exit();
    }

require 'template/base.php';
}
?>