<div class="container my-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-5">
                <div class="display-1 mb-3 text-danger">⚠️</div>
                <h2 class="fw-bold text-dark">Link non valido</h2>
                <p class="text-muted mt-3">
                    <?php echo isset($msg) ? $msg : "Il link di recupero è scaduto o non è più valido."; ?>
                </p>
                <div class="mt-4">
                    <a href="login.php" class="btn btn-outline-dark fw-bold">Torna al Login</a>
                    <a href="password_dimenticata.php" class="btn btn-primary fw-bold ms-2">Richiedi nuovo link</a>
                </div>
            </div>
        </div>
    </div>
</div>