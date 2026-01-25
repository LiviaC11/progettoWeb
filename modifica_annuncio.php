<?php
require_once 'bootstrap.php';

// 1. Controllo sicurezza: l'utente deve essere loggato e admin
if(!isset($_SESSION["id_utente"])) {
    header("location: login.php");
    exit();
}

$id_utente = $_SESSION["id_utente"];
$id_annuncio = $_GET["id"]; // Recuperiamo l'ID dall'URL

// 2. Recuperiamo i dati dell'annuncio dal database
// Nota: Assicurati di avere una funzione getAnnuncioById nel tuo DatabaseHelper
$annuncio = $dbh->getAnnuncioById($id_annuncio);

// Controllo se l'annuncio esiste e appartiene all'utente
if(!$annuncio || $annuncio["id_utente"] != $id_utente) {
    header("location: dashboard.php?msg=errore_permessi");
    exit();
}

// 3. Prepariamo il template
$templateParams["titolo"] = "CoHappy - Modifica Annuncio";
$templateParams["annuncio"] = $annuncio;

// Inseriamo il form direttamente qui o in un file separato
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white p-3">
                        <h4 class="mb-0">📝 Modifica Annuncio</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="processa_annuncio.php" method="POST">
                            <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">
                            <input type="hidden" name="azione" value="modifica">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Titolo</label>
                                <input type="text" name="titolo" class="form-control" value="<?php echo $annuncio['titolo']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrizione</label>
                                <textarea name="descrizione" class="form-control" rows="5" required><?php echo $annuncio['descrizione']; ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Prezzo (€)</label>
                                    <input type="number" name="prezzo" step="0.01" class="form-control" value="<?php echo $annuncio['prezzo']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Città / Zona</label>
                                    <input type="text" name="luogo" class="form-control" value="<?php echo $annuncio['luogo']; ?>" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary fw-bold">Salva Modifiche</button>
                                <a href="dashboard.php" class="btn btn-outline-secondary">Annulla</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>