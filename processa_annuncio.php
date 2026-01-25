<?php
require_once 'bootstrap.php';
require_once 'utils/functions.php';

if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}


// --- AZIONE: INSERISCI NUOVO ---
if(isset($_POST["azione"]) && $_POST["azione"] == "inserisci"){
    $titolo = htmlspecialchars($_POST["titolo"]);
    $descrizione = htmlspecialchars($_POST["descrizione"]);
    $prezzo = $_POST["prezzo"];
    $luogo = htmlspecialchars($_POST["luogo"]);
    $id_utente = $_SESSION["id_utente"];
    
    // Gestione immagine: chiamiamo la funzione che salva il file e ci dà il percorso "img/..."
    $percorsoImmagine = handleImageUpload($_FILES['immagine'] ?? null);

    // Passiamo al DB solo la stringa del percorso!
    $dbh->insertAnnuncio($titolo, $descrizione, $prezzo, $luogo, $id_utente, $percorsoImmagine);
    header("Location: dashboard.php?msg=annuncio_creato");
    exit();
}

// --- AZIONE: MODIFICA ---
if(isset($_POST["azione"]) && $_POST["azione"] == "modifica"){
    $id_annuncio = $_POST["id_annuncio"];
    $titolo = htmlspecialchars($_POST["titolo"]);
    $descrizione = htmlspecialchars($_POST["descrizione"]);
    $prezzo = $_POST["prezzo"];
    $luogo = htmlspecialchars($_POST["luogo"]);
    
    $annuncio = $dbh->getAnnuncioById($id_annuncio);
    if($annuncio && $annuncio['id_utente'] == $_SESSION['id_utente']){
        
        // Se carichi una nuova foto bene, altrimenti handleImageUpload restituisce null
        $nuovoPercorso = handleImageUpload($_FILES['immagine'] ?? null, true);
        
        $dbh->updateAnnuncio($id_annuncio, $titolo, $descrizione, $prezzo, $luogo, $nuovoPercorso);
        header("Location: miei_annunci.php?msg=aggiornato");
    } else {
        header("Location: miei_annunci.php?err=non_autorizzato");
    }
    exit();
}

// --- AZIONE: ELIMINA ---
if(isset($_GET["azione"]) && $_GET["azione"] == "elimina" && isset($_GET["id"])){
    $id_annuncio = $_GET["id"];
    $annuncio = $dbh->getAnnuncioById($id_annuncio);
    
    if($annuncio && $annuncio['id_utente'] == $_SESSION['id_utente']){
        $dbh->deleteAnnuncio($id_annuncio);
        header("Location: miei_annunci.php?msg=eliminato");
    } else {
        header("Location: miei_annunci.php?err=non_autorizzato");
    }
    exit();
}

// --- AZIONE: ATTIVA (Torna Online) ---
if(isset($_GET["azione"]) && $_GET["azione"] == "attiva" && isset($_GET["id"])){
    $id_annuncio = $_GET["id"];
    $annuncio = $dbh->getAnnuncioById($id_annuncio);
    if($annuncio && $annuncio['id_utente'] == $_SESSION['id_utente']){
        $dbh->activateAnnuncio($id_annuncio);
        header("Location: miei_annunci.php?msg=riattivato");
    }
    exit();
}

// --- AZIONE: DISATTIVA (Vai in Pausa) ---
if(isset($_GET["azione"]) && $_GET["azione"] == "disattiva" && isset($_GET["id"])){
    $id_annuncio = $_GET["id"];
    $annuncio = $dbh->getAnnuncioById($id_annuncio);
    if($annuncio && $annuncio['id_utente'] == $_SESSION['id_utente']){
        $dbh->deactivateAnnuncio($id_annuncio);
        header("Location: miei_annunci.php?msg=nascosto");
    }
    exit();
}

header("Location: dashboard.php");
?>