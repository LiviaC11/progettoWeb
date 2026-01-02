<?php
session_start();
define("UPLOAD_DIR", "./upload/");

// Carica le funzioni di utilità (corretto con la 's' come richiesto)
require_once("utils/functions.php");

// Qui in futuro includerai il database:
// require_once("db/database.php");
// $dbh = new DatabaseHelper(...);
?>