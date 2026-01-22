<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Il Mio Profilo</h2>
                    <p class="text-muted">Gestisci le tue informazioni personali</p>
                </div>

                <?php if(isset($templateParams["messaggio"])): ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <?php echo $templateParams["messaggio"]; ?>
                    </div>
                <?php endif; ?>

                <div class="text-center mb-5">
                    <div class="mb-3">
                        <img src="<?php echo UPLOAD_DIR . ($templateParams['utente']['foto_profilo'] ?? 'default_avatar.png'); ?>" 
                             alt="Foto Profilo" 
                             class="rounded-circle shadow-sm border" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <form action="profilo.php" method="POST" enctype="multipart/form-data" class="d-inline-block">
                        <label for="nuova_foto" class="btn btn-outline-dark btn-sm fw-bold">Cambia Foto</label>
                        <input type="file" id="nuova_foto" name="nuova_foto" class="d-none" onchange="this.form.submit()">
                    </form>
                </div>

                <hr class="my-4">

                <form action="profilo.php" method="POST">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Sicurezza Account</h5>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email (non modificabile)</label>
                        <input type="text" class="form-control bg-light" value="<?php echo $_SESSION['email'] ?? ''; ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="nuova_password" class="form-label small fw-bold">Nuova Password</label>
                        <input type="password" name="nuova_password" id="nuova_password" class="form-control" placeholder="Inserisci almeno 8 caratteri" minlength="8">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark fw-bold py-2 shadow-sm">Salva Modifiche</button>
                    </div>
                </form>

                <div class="text-center mt-5">
                    <a href="logout.php" class="text-danger fw-bold text-decoration-none">Esci dall'account</a>
                </div>
            </div>
        </div>
    </div>
</div>