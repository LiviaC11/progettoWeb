<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow border-0 p-4">
                <h2 class="text-center fw-bold mb-4">Unisciti a CoHappy</h2>
                
                <?php if(isset($templateParams["errore_reg"])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $templateParams["errore_reg"]; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="registrazione.php">
                    
                    <h5 class="fw-bold mb-3 text-secondary">Dati Personali</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cognome" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="cognome" name="cognome" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Indirizzo Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3 text-secondary">La tua Casa</h5>
                    <div class="mb-3">
                        <label for="scelta_casa" class="form-label">Cosa vuoi fare?</label>
                        <select class="form-select" id="scelta_casa" name="scelta_casa" onchange="toggleCasa()">
                            <option value="unisciti">Unisciti con codice invito</option>
                            <option value="crea">Crea una nuova unità abitativa</option>
                        </select>
                    </div>

                    <div id="div_codice" class="mb-3 p-3 bg-light rounded border">
                        <label for="codice_invito" class="form-label fw-bold text-primary">Codice Invito</label>
                        <input type="text" class="form-control" id="codice_invito" name="codice_invito" placeholder="Inserisci il codice ricevuto dai coinquilini">
                    </div>

                    <div id="div_nome_casa" class="mb-3 p-3 bg-light rounded border d-none">
                        <label for="nome_casa" class="form-label fw-bold text-success">Nome della tua nuova Casa</label>
                        <input type="text" class="form-control" id="nome_casa" name="nome_casa" placeholder="Esempio: Casa degli Studenti Bologna">
                        <small class="text-muted">Diventerai l'amministratore di questa casa.</small>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark btn-lg fw-bold">Completa Registrazione</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p>Hai già un account? <a href="login.php" class="text-dark fw-bold">Accedi</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Gestisce lo switch visivo tra unione a casa esistente e creazione nuova
 */
function toggleCasa() {
    const scelta = document.getElementById('scelta_casa').value;
    const divCodice = document.getElementById('div_codice');
    const divNomeCasa = document.getElementById('div_nome_casa');

    if (scelta === 'crea') {
        divCodice.classList.add('d-none');
        divNomeCasa.classList.remove('d-none');
        document.getElementById('codice_invito').required = false;
        document.getElementById('nome_casa').required = true;
    } else {
        divCodice.classList.remove('d-none');
        divNomeCasa.classList.add('d-none');
        document.getElementById('codice_invito').required = true;
        document.getElementById('nome_casa').required = false;
    }
}
</script>