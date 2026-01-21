<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "ADMIN - Segnalazioni";
$templateParams["nome"] = "visualizza_segnalazioni.php";
$templateParams["AnnunciSegnalati"] = $dbh->getSegnalazioni();

require 'template\base_admin.php';
?>