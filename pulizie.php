<?php
require_once 'bootstrap.php';

// Controllo Login
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

$id_casa = $_SESSION["id_casa"];

// Se l'utente non ha una casa, via!
if(!$id_casa){
    header("Location: dashboard.php");
    exit;
}

// 1. GESTIONE AGGIUNTA TURNO
if(isset($_POST["azione"]) && $_POST["azione"] == "add_pulizia"){
    $compito = htmlspecialchars($_POST["compito"]);
    $data = $_POST["data_scadenza"];
    $assegnato_a = $_POST["assegnato_a"];

    if(!empty($compito) && !empty($data) && !empty($assegnato_a)){
        $dbh->insertTurnoPulizia($compito, $data, $assegnato_a, $id_casa);
        header("Location: pulizie.php?msg=turno_aggiunto");
        exit;
    }
}

// 2. GESTIONE COMPLETAMENTO TURNO (Opzionale ma utile)
if(isset($_GET["azione"]) && $_GET["azione"] == "completato" && isset($_GET["id"])){
    // Qui servirebbe una funzione updateTurnoStato($id, 1) nel DB
    // $dbh->updateTurnoStato($_GET["id"], 1);
    // header("Location: pulizie.php");
    // exit;
}

// 2. GESTIONE COMPLETAMENTO TURNO (NUOVO! 🔥)
if(isset($_POST["azione"]) && $_POST["azione"] == "completa_pulizia"){
    $id_turno = $_POST["id_turno"];
    
    // Aggiorniamo lo stato a 1 (Fatto)
    $dbh->updateTurnoStato($id_turno, 1);
    
    // Ricarichiamo la pagina per vedere il badge verde
    header("Location: pulizie.php?msg=completato");
    exit;
}

// 3. DATI PER IL TEMPLATE
$templateParams["coinquilini"] = $dbh->getCoinquilini($id_casa);
$templateParams["turni"] = $dbh->getTurniPulizie($id_casa);

$templateParams["titolo"] = "CoHappy - Gestione Pulizie";
$templateParams["nome"] = "template/pulizie_template.php";
$templateParams["turni_pulizie"] = $dbh->getTurniMeseSuccessivo($id_casa);


require 'template/base.php';
?>