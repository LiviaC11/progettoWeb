<?php
require_once 'bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recupero e sanificazione dei dati dal form del popup
    $id_annuncio = isset($_POST['id_annuncio']) ? intval($_POST['id_annuncio']) : 0;
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $messaggio = htmlspecialchars($_POST['messaggio']);
    
    // Se l'ID annuncio è fake, lo rispediamo al mittente
    if($id_annuncio === 0) {
        header("Location: annunci.php");
        exit();
    }

    // Gestione Foto del candidato (usiamo la nostra funzione baddie in utils/functions.php)
    // Se non carica nulla, handleImageUpload ci darà img/nophoto.png
    $percorsoFoto = handleImageUpload($_FILES['foto'] ?? null, false, 'candidato_');

    // Chiamiamo la funzione del Database Helper (il nostro Canvas!)
    $risultato = $dbh->insertCandidatura($id_annuncio, $nome, $email, $messaggio, $percorsoFoto);

    if($risultato){
        // Se tutto va bene, mostriamo la pagina di successo
        $templateParams["titolo"] = "CoHappy - Candidatura Inviata";
        $templateParams["nome"] = "template/risposta_template.php";
    } else {
        // Se il database fa i capricci, errore
        header("Location: annunci.php?err=invio_fallito");
        exit();
    }

    require 'template/base.php';
} else {
    // Se qualcuno prova a fare il furbo e accedere via GET
    header("Location: annunci.php");
    exit();
}
?>