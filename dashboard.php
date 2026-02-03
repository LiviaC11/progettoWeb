<?php
require_once 'bootstrap.php';

// 1. PROTEZIONE BASE: Solo utenti loggati
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

$id_utente = $_SESSION["id_utente"];
$id_casa = $_SESSION["id_casa"] ?? null;

// 2. GESTIONE AZIONI (POST/GET)

// Unione ad una casa
if(isset($_POST["azione"]) && $_POST["azione"] == "unisciti_casa" && isset($_POST["codice_invito"])){
    $codice = ($_POST["codice_invito"]);
    $nuovo_id_casa = $dbh->joinHouseWithCode($id_utente, $codice);
    
    if($nuovo_id_casa){
        $_SESSION["id_casa"] = $nuovo_id_casa;
        header("location: dashboard.php?successo=casa_unita");
        exit();
    } else {
        $templateParams["errore_casa"] = "Codice invito non valido.";
    }
}

// Abbandono casa
if(isset($_GET["azione"]) && $_GET["azione"] == "abbandona"){
    if($dbh->leaveHouse($id_utente)){
        $_SESSION["id_casa"] = null;
        header("location: dashboard.php");
        exit();
    }
}

// Espulsione utente
if(isset($_POST["azione"]) && $_POST["azione"] == "espelli_utente" && isset($_POST["id_target"])){
    if($_SESSION["ruolo"] === "admin_casa"){
        $dbh->leaveHouse($_POST["id_target"]);
        header("location: dashboard.php?msg=utente_rimosso");
        exit();
    }
}

// Passaggio di proprietà Admin
if(isset($_POST["azione"]) && $_POST["azione"] == "passa_admin" && isset($_POST["id_target"])){
    if($_SESSION["ruolo"] === "admin_casa"){
        if($dbh->passaAdmin($id_utente, $_POST["id_target"])){
            $_SESSION["ruolo"] = "studente"; // Aggiorniamo subito la sessione dell'ex-admin
            header("location: dashboard.php?msg=ruolo_trasferito");
            exit();
        }
    }
}

// Nuovo Annuncio (Verifica RUOLO lato server)
if(isset($_POST["azione"]) && $_POST["azione"] == "inserisci_annuncio"){
    $user = $dbh->getUserById($id_utente);
    if($user["ruolo"] === "admin_casa") {
        $dbh->insertAnnuncio(
            ($_POST["titolo"]),
            ($_POST["descrizione"]),
            $_POST["prezzo"],
            ($_POST["luogo"]),
            $id_utente,
            $id_casa
        );
        header("location: dashboard.php?msg=annuncio_pubblicato");
        exit();
    }
}

// Aggiornamento dati Casa (Nome e Codice)
if(isset($_POST["azione"]) && $_POST["azione"] == "aggiorna_casa"){
    if($_SESSION["ruolo"] === "admin_casa" && isset($_SESSION["id_casa"])){
        $nuovo_nome = $_POST["nome_casa"];
        $nuovo_codice = strtoupper($_POST["codice_invito"]);
        
        if($dbh->updateHouse($_SESSION["id_casa"], $nuovo_nome, $nuovo_codice)){
            header("location: dashboard.php?msg=casa_aggiornata");
            exit();
        } else {
            $templateParams["errore_casa"] = "Errore: il codice potrebbe essere già in uso.";
        }
    }
}

// --- GESTIONE FORUM CASA ---
if(isset($_POST["azione"]) && $_POST["azione"] == "invia_messaggio_forum") {
    $testo = $_POST["testo"];
    $is_anonimo = isset($_POST["is_anonimo"]) ? 1 : 0;
    $parent_id = !empty($_POST["parent_id"]) ? $_POST["parent_id"] : null;
    $dbh->insertMessaggioCasa($id_casa, $id_utente, $testo, $is_anonimo, $parent_id);
    header("location: dashboard.php#forum-casa");
    exit();
}

if (isset($_POST["azione"]) && $_POST["azione"] == "cancella_messaggio_forum") {
    $id_messaggio = $_POST["id_messaggio"];
    $id_utente = $_SESSION["id_utente"];

    // 1. Connessione (se non è già attiva)
    // $pdo = new PDO(...); 

    // 2. Eliminiamo il messaggio (controllando che l'utente sia l'autore)
    $stmt = $pdo->prepare("DELETE FROM messaggi_casa WHERE id_messaggio = ? AND id_utente = ?");
    $stmt->execute([$id_messaggio, $id_utente]);

    header("location: dashboard.php");
    exit();
}
$templateParams["utente"] = $dbh->getUserById($id_utente);

// Se l'utente non ha una casa, non carichiamo il resto dei dati
if ($id_casa) {
    $templateParams["miei_annunci"] = $dbh->getAnnunciByUtente($id_utente);
    $templateParams["spese_recenti"] = $dbh->getRecentExpenses($id_casa, 3);
    $templateParams["prossimo_turno"] = $dbh->getNextCleaningTurn($id_casa);
    $templateParams["turni_pulizie"] = $dbh->getTurniMeseSuccessivo($id_casa);
    $templateParams["coinquilini_casa"] = $dbh->getCoinquilini($id_casa);
    $templateParams["messaggi_forum"] = $dbh->getMessaggiForum($id_casa);
}

$templateParams["titolo"] = "CoHappy - Dashboard";
$templateParams["nome"] = "template/dashboard_template.php";

require 'template/base.php';
?>