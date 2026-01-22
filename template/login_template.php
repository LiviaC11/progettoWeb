<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0 p-4">
                <h2 class="text-center fw-bold mb-4">Accedi a CoHappy</h2>

                <?php if(isset($templateParams["messaggio_successo"])): ?>
                    <div class="alert alert-success mt-3" role="alert">
                        <?php echo $templateParams["messaggio_successo"]; ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($templateParams["errore_login"])): ?>
                    <div class="alert alert-danger">
                        <?php echo $templateParams["errore_login"]; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="text-end mb-3">
                        <a href="password_dimenticata.php" class="text-decoration-none small fw-bold text-muted">
                            Password dimenticata?
                        </a>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark btn-lg fw-bold">Login</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p>Non hai un account? <a href="registrazione.php" class="text-dark fw-bold">Registrati ora</a></p>
                </div>
            </div>
        </div>
    </div>
</div>