<?php
// Avvia la sessione solo se non è già attiva (evita errori "Session already started")
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definizione costanti per i percorsi (Utility)
define("UPLOAD_DIR", "./upload/");

// Inclusione helper database e funzioni
require_once("db/database.php");
require_once("utils/functions.php");

// Connessione al Database
// Sostituisci con i tuoi dati reali (localhost, root, password, nome_db, port)
$dbh = new DatabaseHelper("localhost", "root", "", "cohappy_db", 3306);
?>