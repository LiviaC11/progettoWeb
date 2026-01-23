<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "CoHappy - Annunci";
$templateParams["nome"] = "annunci_template.php";
$templateParams["annunci"] = $dbh->getAnnunci();

require 'template/base.php';
?>