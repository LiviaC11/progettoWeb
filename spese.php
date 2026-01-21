<?php
require_once 'bootstrap.php';

// Protezione
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

$templateParams["spese"] = $dbh->getSpeseByCasa($id_casa);
$templateParams["titolo"] = "CoHappy - Spese";
$templateParams["nome"] = "template/spese_template.php";

require 'template/base.php';
?>