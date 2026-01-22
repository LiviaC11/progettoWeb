<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "CoHappy - ADMIN";
$templateParams["nome"] = "admin_index_template.php";
$templateParams["numUtenti"] = $dbh->countUsers();
$templateParams["numAnnunciAtt"] = $dbh->countAd();
$templateParams["numSegnalazioniAtt"] = $dbh->countReports();
$templateParams["UtentiOggi"] = $dbh->getNewUsersToday();
$templateParams["AnnunciSegnalati"] = $dbh->getSegnalazioni();

require 'template\base_admin.php';
?>