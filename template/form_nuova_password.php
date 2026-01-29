<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4">
                <h2 class="fw-bold mb-3 text-center">🔑 Nuova Password</h2>
                <p class="text-muted text-center mb-4">Inserisci una nuova password sicura per il tuo account.</p>
                
                <form action="recupero.php" method="POST">
                    <input type="hidden" name="id_utente" value="<?php echo $templateParams['id_utente']; ?>">
                    <input type="hidden" name="token" value="<?php echo $templateParams['token']; ?>">

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-bold">Nuova Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required minlength="8">
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-bold">Conferma Nuova Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="8">
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Aggiorna Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/validazione.js"></script>