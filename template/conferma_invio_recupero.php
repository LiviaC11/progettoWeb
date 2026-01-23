<div class="container my-5 text-center">
    <div class="card shadow-sm p-4 border-0">
        <?php if(isset($templateParams["link_generato"])): ?>
            <h2 class="text-success fw-bold">Richiesta Ricevuta</h2>
            <p>Clicca sul link qui sotto per simulare l'apertura dell'email:</p>
            <div class="alert alert-info py-3">
                <a href="<?php echo $templateParams['link_generato']; ?>" class="fw-bold">
                    Recupera la mia Password
                </a>
            </div>
        <?php else: ?>
            <h2 class="text-danger">Errore</h2>
            <p><?php echo $templateParams["errore"]; ?></p>
            <a href="password_dimenticata.php" class="btn btn-primary">Riprova</a>
        <?php endif; ?>
    </div>
</div>