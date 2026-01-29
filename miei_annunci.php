<?php
require_once 'bootstrap.php';

// Controllo Login
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

$templateParams["titolo"] = "CoHappy - I Miei Annunci";
$templateParams["nome"] = "template/miei_annunci_template.php";

// Recuperiamo gli annunci
$annunci = $dbh->getAnnunciByUtente($_SESSION["id_utente"]);

// Per ogni annuncio, recuperiamo anche le sue candidature ✨
foreach($annunci as $key => $annuncio) {
    $annunci[$key]['candidature'] = $dbh->getCandidatureByAnnuncio($annuncio['id_annuncio']);
}

$templateParams["annunci"] = $annunci;

require 'template/base.php';
?>