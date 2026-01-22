<?php
require_once 'bootstrap.php';

// Protezione: controllo che un utente sia loggato
if(!isset($_SESSION["id_utente"])) {
    header("location: login.php");
    exit();
}

$id_casa = $_SESSION["id_casa"];
$id_utente = $_SESSION["id_utente"];

// LOGICA CRUD: Eliminazione
if(isset($_GET["azione"]) && $_GET["azione"] == "elimina" && isset($_GET["id"])){
    $dbh->deleteSpesa($_GET["id"]);
    header("location: spese.php?msg=eliminata");
    exit();
}

// LOGICA CRUD: Inserimento
if(isset($_POST["descrizione"]) && isset($_POST["importo"])){
    $desc = htmlspecialchars($_POST["descrizione"]);
    $importo = $_POST["importo"];
    $data = $_POST["data"];
    $dbh->insertSpesa($desc, $importo, $data, $id_utente, $id_casa);
    header("location: spese.php?msg=inserita");
    exit();
}

if($id_casa){
$numero_coinquilini = $dbh->getNumeroMembriCasa($id_casa);
$templateParams["spese"] = $dbh->getSpeseByCasa($id_casa);
$templateParams["num_persone"] = $numero_coinquilini;
$templateParams["coinquilini"] = $dbh->getUtentiByCasa($id_casa);
}else{
    $templateParams["num_persone"] = 0;
    $templateParams["spese"] = [];
    $templateParams["coinquilini"] = [];
}


$templateParams["titolo"] = "CoHappy - Spese";
$templateParams["nome"] = "template/spese_template.php";

require 'template/base.php';
?>