<?php
require_once 'bootstrap.php';

// Svuota l'array di sessione
$_SESSION = array();

// Distrugge la sessione
session_destroy();

// Reindirizza alla home o al login
header("location: index.php");
exit();
?>