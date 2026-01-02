<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "CoHappy - Annunci";
$templateParams["nome"] = "annunci_template.php";
$templateParams["annunci"] = $dbh->getRandomAnnunci(6);

require 'template/base.php';
?>