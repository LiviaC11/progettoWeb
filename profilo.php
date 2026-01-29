<?php
require_once 'bootstrap.php';

// Controllo accesso: se non è loggato, va al login
if(!isset($_SESSION["id_utente"])){
    header("location: login.php");
    exit();
}

$id_utente = $_SESSION["id_utente"];

// Gestione aggiornamenti dati utente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nuova_password"]) && !empty($_POST["nuova_password"])) {
        $password_hash = password_hash($_POST["nuova_password"], PASSWORD_BCRYPT);
        $dbh->updateUserPassword($id_utente, $password_hash);
        $templateParams["messaggio"] = "Password aggiornata con successo!";
    }

    if (isset($_FILES["nuova_foto"]) && $_FILES["nuova_foto"]["error"] === UPLOAD_ERR_OK) {
        $nomeFoto = time() . "_" . basename($_FILES["nuova_foto"]["name"]);
        if (move_uploaded_file($_FILES["nuova_foto"]["tmp_name"], UPLOAD_DIR . $nomeFoto)) {
            $dbh->updateUserPhoto($id_utente, $nomeFoto);
            $templateParams["messaggio"] = "Foto profilo aggiornata!";
        }
    }
}

// Recupero dati attuali dell'utente dal database
$templateParams["utente"] = $dbh->getUserById($id_utente);
$templateParams["titolo"] = "CoHappy - Il Mio Profilo";
$templateParams["nome"] = "template/profilo_template.php";

require 'template/base.php';
?>